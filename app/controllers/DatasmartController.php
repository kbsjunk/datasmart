<?php

use Kitbs\Datasmart\Format\Format;
use Kitbs\Datasmart\Barcode\Barcode;
// use Kitbs\PhpQrCode\QRcode;

class DatasmartController extends BaseController {

	public $cache;

	public function __construct() {
		$this->cache = true;//Config::get('datasmart::cache');
	}

	public function doBarcodeNoSize($against, $size, $input = false, $mime = 'png')
	{
		return $this->doBarCode($against, '200', $input, $mime);
	}

	private function outputFile($file)
	{
		if (File::exists($file)) {

			$type = new Symfony\Component\HttpFoundation\File\File($file);
			$type = $type->getMimeType();

			$response = Response::make(File::get($file), 200);
			$response->header('Content-Type', $type);

			return $response;
		}
	}

	private function parseSize($size, $format) {
		$size = trim($size, 'x');
		$sizes = array_slice(explode('x', $size.'x'.$size), 0, 2);
		
		if ($format == 'qr') {
			switch ($sizes[0]) {
				case 'L':
				$sizes[0] = QR_ECLEVEL_L;
				break;
				case 'M':
				$sizes[0] = QR_ECLEVEL_M;
				break;
				case 'Q':
				$sizes[0] = QR_ECLEVEL_Q;
				break;
				case 'H':
				$sizes[0] = QR_ECLEVEL_H;
				break;
				default:
				$sizes[0] = QR_ECLEVEL_L;
			}
			if (!Validate::int()->between(1, 4)->validate($sizes[1])) {
				$sizes[1] = 3;
			}
			return $sizes;
		}
		else {

		}
	}

	public function doBarcode($against, $size, $input = false, $mime = 'png')
	{
		$imageTypes = array(
			'png',
			'svg',
			);

		if (!in_array($mime, $imageTypes)) {
			App::abort(404);
		}

		$response = array($against, $size, $input);

		if ($this->cache) {

			$filePath = storage_path('imagecache/barcode/');
			if (!File::exists($filePath)) {
				File::makeDirectory($filePath, 0777, true);
			}
			$cacheKey = $filePath.md5(serialize($response)).'.'.$mime;

			if ($output = $this->outputFile($cacheKey)) return $output;
		}
		else {
			$cacheKey = false;
		}

		if ($against == 'qr') {

			list($ecLevel, $pixelSize) = $this->parseSize($size, 'qr');

			switch ($mime) {
				case 'png':
				$output = QRcode::png($input, $cacheKey, $ecLevel, $pixelSize);
				break;
				case 'svg':
				$output = QRcode::svg($input, $cacheKey, $ecLevel, $pixelSize);
				break;
				default:
				return App::abort(404);
			}

			if (!$this->cache) {
				echo $output;
				die;
			}

			return $this->outputFile($cacheKey);

		}
		else {

			if (!Barcode::allowed($against)) {
				App::abort(404);
			}
			else {
				Barcode::create($against, $input, $mime);die;
			}
		}

	}

	public function doValidate($mime = 'json', $against, $input = false, $second = null, $third = null, $fourth = null)
	{

		$arguments = array_filter(array($second, $third, $fourth));

		$response = array(
			'against'   => $against,
			'input'     => $input,
			);

		if (count($arguments)) {
			$response['arguments'] = $arguments;
		}

		if ($this->cache) {
			$cacheKey = 'validate::'.md5(serialize($response));

			// Cache::forget($cacheKey);

			if (Cache::has($cacheKey)) {
				return $this->doResponse($mime, Cache::get($cacheKey), true, true);
			}
		}

		if (!Validate::allowed($against)) {
			$response['message'] = \Respect\Validation\Exceptions\ValidationException::format('Validation method "{{name}}" does not exist.', array('name'=>$against));
			return $this->doResponse($mime, $response, false);
		}

		$response['valid'] = (int) Validate::start($against, $arguments)->validate($input);

		if ($response['valid'] && $format = Format::start($against, $arguments)->format($input)) {
			$response['format'] = $format;
		}

		// } catch(\InvalidArgumentException $e) {
		// 	$response['valid'] = 0;
		// 	$response['error'] = $e->getFullMessage();
		// }

		if ($this->cache) {
			Cache::put($cacheKey, array(Carbon::now()->toDateTimeString(), $response), 10);
		}

		return $this->doResponse($mime, $response);

	}

	private function doResponse($mime, $response, $success = true, $cached = false) {

		$status = $success ? 'success' : 'fail';
		$payload = array('status' => $status, 'data' => $response);

		if ($cached) {
			// $payload['cached'] = 1;
			$dateTime = $payload['data'][0];

			if ($mime=='xml') { $dateTime = implode('T', explode(' ', $dateTime)); }
			$payload['cachedSince'] = $dateTime;
			$payload['data'] = $payload['data'][1];
		}

		switch ($mime) {
			case 'json':
			return Response::json($payload);
			break;

			case 'xml':
			return Response::xml($payload);
			break;

			case 'txt':
			if ($success) {
				return Response::make(Validate::tell($payload['data']['valid'], array('true', 'false')), 200);
			}
			else {
				return Response::make(null, 404);
			}
			break;

			// case 'csv':
			// if ($success) {
			// 	$response = array($status, $payload['data']['against'], $payload['data']['input'], Validate::tell($payload['data']['valid']));
			// 	return Response::make(implode(',', $response), 200);
			// }
			// else {
			// 	return Response::make(null, 404);
			// }
			// break;

			default:
			App::abort(404);
			break;
		}

	}

}
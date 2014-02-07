<?php

class ValidateController extends BaseController {

	public function doValidate($against, $input = false, $second = null, $third = null, $fourth = null)
	{

		$response = array(
			'against'   => $against,
			'input'     => $input,
			'arguments' => array_filter(array($second, $third, $fourth))
			);

		$cacheKey = 'validate::'.md5(serialize($response));

		//Cache::forget($cacheKey);

		if (Cache::has($cacheKey)) {
			return $this->doResponse(Cache::get($cacheKey), true, true);
		}

		switch (strtolower($against)) {
			case 'abn':
			$valid = Validate::abn()->validate($input);
			break;
			case 'isbn':
			$valid = Validate::isbn()->validate($input);
			break;
			case 'ean':
			$valid = Validate::ean()->validate($input);
			break;
			case 'vat':
			case 'vatin':
			$valid = Validate::vat()->validate($input);
			break;
			case 'alnum':
			$valid = Validate::alnum($second)->validate($input);
			break;
			case 'alpha':
			$valid = Validate::alpha($second)->validate($input);
			break;
			case 'between':
			if ($second && $third) {
				$valid = Validate::between($second, $third, $fourth)->validate($input);
			}
			else {
				return $this->doResponse($response, false);
			}
			break;
			case 'bool':
			$valid = Validate::bool()->validate($input);
			break;
			case 'charset':
			$valid = Validate::charset($second)->validate($input);
			break;
			case 'cnh':
			$valid = Validate::cnh()->validate($input);
			break;
			case 'cnpj':
			$valid = Validate::cnpj()->validate($input);
			break;
			case 'consonant':
			case 'consonants':
			$valid = Validate::consonant($second)->validate($input);
			break;
			case 'contains':
			$valid = Validate::contains($second, $third)->validate($input);
			break;
			case 'countrycode':
			$valid = Validate::countryCode()->validate($input);
			break;
			case 'cpf':
			$valid = Validate::cpf()->validate($input);
			break;
			case 'creditcard':
			$valid = Validate::creditCard()->validate($input);
			break;
			case 'date':
			$valid = Validate::date($second)->validate($input);
			break;
			case 'digit':
			case 'digits':
			$valid = Validate::digit($second)->validate($input);
			break;
			case 'domain':
			$valid = Validate::domain()->validate($input);
			break;
			case 'email':
			$valid = Validate::email()->validate($input);
			break;
			case 'endswith':
			$valid = Validate::endsWith($second, $third)->validate($input);
			break;
			case 'equals':
			$valid = Validate::equals($second, $third)->validate($input);
			break;
			case 'even':
			$valid = Validate::even()->validate($input);
			break;
			case 'float':
			$valid = Validate::float()->validate($input);
			break;
			case 'in':
			$valid = Validate::in($second, $third)->validate($input);
			break;
			case 'int':
			case 'integer':
			$valid = Validate::int()->validate($input);
			break;
			case 'ip':
			case 'ipaddress':
			$valid = Validate::ip($second)->validate($input);
			break;
			case 'json':
			$valid = Validate::json()->validate($input);
			break;
			case 'leapdate':
			$valid = Validate::leapDate($second)->validate($input);
			break;
			case 'leapyear':
			$valid = Validate::leapYear()->validate($input);
			break;
			case 'length':
			$valid = Validate::length($second, $third, $fourth)->validate($input);
			break;
			case 'lowercase':
			$valid = Validate::lowercase()->validate($input);
			break;
			case 'macaddress':
			$valid = Validate::macAddress()->validate($input);
			break;
			case 'max':
			$valid = Validate::max($second, $third)->validate($input);
			break;
			case 'min':
			$valid = Validate::min($second, $third)->validate($input);
			break;
			case 'minimumage':
			$valid = Validate::minimumAge($second)->validate($input);
			break;
			case 'multiple':
			$valid = Validate::multiple($second)->validate($input);
			break;
			case 'negative':
			$valid = Validate::negative()->validate($input);
			break;
			case 'noneof':
			$valid = Validate::noneOf()->validate($input);
			break;
			case 'notempty':
			$valid = Validate::notEmpty()->validate($input);
			break;
			case 'nowhitespace':
			$valid = Validate::noWhitespace()->validate($input);
			break;
			case 'nullvalue':
			case 'null';
			$valid = Validate::nullValue()->validate($input);
			break;
			case 'numeric':
			$valid = Validate::numeric()->validate($input);
			break;
			case 'object':
			$valid = Validate::object()->validate($input);
			break;
			case 'odd':
			$valid = Validate::odd()->validate($input);
			break;
			case 'oneof':
			$valid = Validate::oneOf()->validate($input);
			break;
			case 'perfectsquare':
			$valid = Validate::perfectSquare()->validate($input);
			break;
			case 'phone':
			$valid = Validate::phone()->validate($input);
			break;
			case 'positive':
			$valid = Validate::positive()->validate($input);
			break;
			case 'primenumber':
			$valid = Validate::primeNumber()->validate($input);
			break;
			case 'prnt':
			$valid = Validate::prnt($second)->validate($input);
			break;
			case 'punct':
			$valid = Validate::punct($second)->validate($input);
			break;
			case 'readable':
			$valid = Validate::readable()->validate($input);
			break;
			case 'regex':
			$valid = Validate::regex($second)->validate($input);
			break;
			case 'roman':
			$valid = Validate::roman()->validate($input);
			break;
			case 'slug':
			$valid = Validate::slug()->validate($input);
			break;
			case 'space':
			$valid = Validate::space($second)->validate($input);
			break;
			case 'startswith':
			$valid = Validate::startsWith($startValue, $identical)->validate($input);
			break;
			case 'string':
			$valid = Validate::string()->validate($input);
			break;
			case 'tld':
			$valid = Validate::tld()->validate($input);
			break;
			case 'uppercase':
			$valid = Validate::uppercase()->validate($input);
			break;
			case 'version':
			$valid = Validate::version()->validate($input);
			break;
			case 'vowel':
			case 'vowels':
			$valid = Validate::vowel()->validate($input);
			break;
			case 'xdigit':
			case 'hexadecimal':
			case 'hex':
			$valid = Validate::xdigit($second)->validate($input);
			break;

			default:
			return $this->doResponse($response, false);
		}

		$response['valid'] = $valid ? 1 : 0;


		// } catch(\InvalidArgumentException $e) {
		// 	$response['valid'] = 0;
		// 	$response['error'] = $e->getFullMessage();
		// }

		Cache::put($cacheKey, array(Carbon::now()->toDateTimeString(), $response), 10);

		return $this->doResponse($response);

	}

	private function doResponse($response, $success = true, $cached = false) {

		$status = $success ? 'success' : 'fail';
		$payload = array('status' => $status, 'data' => $response);
		if ($cached) {
			$payload['cached'] = 1;
			$payload['cachedSince'] = $payload['data'][0];
			$payload['data'] = $payload['data'][1];
		}

		return Response::json($payload);
	}

}
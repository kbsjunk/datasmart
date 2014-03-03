<!DOCTYPE html>
<html>
<head>
	<title>Datasmart API Test</title>
	{{ HTML::style('assets/style.min.css') }}
</head>
<body>
	<div class="container">
		<h1>Datasmart API Test</h1>

		<form method="post" action="/" role="form">
			<div class="form-inline">
				<div class="form-group">
					<p class="form-control-static">//api/v1/</p>
				</div>
				<div class="form-group">
					<select name="function" id="function" class="form-control input-sm">
						<option>validate</option>
						<option>lookup</option>
					</select>
				</div>
				<div class="form-group">
					<p class="form-control-static">/</p>
				</div>
				<div class="form-group">
					<select name="entity" id="entity" class="form-control input-sm">
						<option>abn</option>
					</select>
				</div>
				<div class="form-group">
					<p class="form-control-static">.</p>
				</div>
				<div class="form-group">
					<select name="format" id="format" class="form-control input-sm">
						<option selected>json</option>
						<option>xml</option>
					</select>
				</div>
			</div>
			<hr>
			<div class="form-group">
				<label class="control-label col-sm-3" for="input">input</label>
				<div class="col-sm-9">
					<input type="text" class="form-control" id="input">
				</div>
			</div>

			<div class="form-group">
				<input type="submit" id="apitest" name="submit" value="Submit Request" class="btn btn-primary" />
			</div>

			<div class="form-group">
				<label class="control-label col-sm-3" for="output">output</label>
				<div class="col-sm-9">
					<pre id="output"><code></code></pre>
				</div>
			</div>

		</form>
	</div>
	{{ HTML::script('assets/script.min.js') }}
</body>
</html>
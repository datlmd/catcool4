<!DOCTYPE html>
<html lang="vi">
<head>
	<meta charset="UTF-8">
	<title>Installation - Cat Cool</title>
	<meta name="description" content="The small framework with powerful features">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" type="image/png" href="/favicon.ico"/>

	<!-- STYLES -->
	<link rel="stylesheet" type="text/css" href="<?= base_url('common/plugin/bootstrap/css/bootstrap.min.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?= base_url('common/plugin/bootstrap/css/bootstrap-utilities.min.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?= base_url('common/plugin/fonts/fontawesome/css/fontawesome-all.css') ?>">

	<script src="<?= base_url('common/plugin/bootstrap/js/bootstrap.bundle.min.js') ?>" type="text/javascript"></script>
	<script src="<?= base_url('common/plugin/jquery/jquery.min.js') ?>" type="text/javascript"></script>
</head>
<body>
<div class="container my-5" style="max-width: 800px;">
	<h1 class="text-center text-primary lh-1">
		Cài đặt Cat Cool - CI <?= CodeIgniter\CodeIgniter::CI_VERSION ?><br/>
		<small>Install Cat Cool</small>
	</h1>

	<div class="my-3">
		<figure data-bs-toggle="collapse" data-bs-target="#collapse_server" aria-expanded="false" aria-controls="collapse_server">
			<blockquote class="blockquote">
				<h2>1 - Kiểm tra thiết lập server</h2>
			</blockquote>
			<figcaption class="blockquote-footer">
				Check your server is set-up correctly
			</figcaption>
		</figure>

		<ul class="list collapse show" id="collapse_server">
			<li>
				<b>Kiểm tra cấu hình PHP đuợc yêu cầu như bên duới</b><br/>
				<small>Please configure your PHP settings to match requirement listed below</small>
				<div class="table-responsive">
					<table class="table table-striped table-hover table-bordered second my-3">
						<thead>
							<tr class="text-center">
								<th>PHP Settings</th>
								<th>Current settings</th>
								<th>Required Settings</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>PHP Version</td>
								<td class="text-center">
									<?= PHP_VERSION ?>
								</td>
								<td class="text-center">7.3+</td>
								<td class="text-center">
									<?php if (version_compare(PHP_VERSION, '7.3', '<')): ?>
										<i class="fas fa-exclamation-triangle text-danger"></i>
									<?php else: ?>
										<i class="fas fa-check text-success"></i>
									<?php endif ?>
								</td>
							</tr>
							<tr <?php if ($register_globals): ?>class="text-danger"<?php endif ?>>
								<td>Register Globals</td>
								<td class="text-center">
									<?php if ($register_globals): ?>
										ON
									<?php else: ?>
										OFF
									<?php endif ?>
								</td>
								<td class="text-center">OFF</td>
								<td class="text-center">
									<?php if ($register_globals): ?>
										<i class="fas fa-exclamation-triangle text-danger"></i>
									<?php else: ?>
										<i class="fas fa-check text-success"></i>
									<?php endif ?>
								</td>
							</tr>
							<tr <?php if ($magic_quotes_gpc): ?>class="text-danger"<?php endif ?>>
								<td>Magic Quotes GPC</td>
								<td class="text-center">
									<?php if ($magic_quotes_gpc): ?>
										ON
									<?php else: ?>
										OFF
									<?php endif ?>
								</td>
								<td class="text-center">OFF</td>
								<td class="text-center">
									<?php if ($magic_quotes_gpc): ?>
										<i class="fas fa-exclamation-triangle text-danger"></i>
									<?php else: ?>
										<i class="fas fa-check text-success"></i>
									<?php endif ?>
								</td>
							</tr>
							<tr <?php if (!$file_uploads): ?>class="text-danger"<?php endif ?>>
								<td>File Uploads</td>
								<td class="text-center">
									<?php if ($file_uploads): ?>
										ON
									<?php else: ?>
										OFF
									<?php endif ?>
								</td>
								<td class="text-center">ON</td>
								<td class="text-center">
									<?php if (!$file_uploads): ?>
										<i class="fas fa-exclamation-triangle text-danger"></i>
									<?php else: ?>
										<i class="fas fa-check text-success"></i>
									<?php endif ?>
								</td>
							</tr>
							<tr <?php if ($session_auto_start): ?>class="text-danger"<?php endif ?>>
								<td>Session Auto Start</td>
								<td class="text-center">
									<?php if ($session_auto_start): ?>
										ON
									<?php else: ?>
										OFF
									<?php endif ?>
								</td>
								<td class="text-center">OFF</td>
								<td class="text-center">
									<?php if ($session_auto_start): ?>
										<i class="fas fa-exclamation-triangle text-danger"></i>
									<?php else: ?>
										<i class="fas fa-check text-success"></i>
									<?php endif ?>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</li>

			<li>
				<b>Kiểm tra cài đặt PHP extensions như bên duới</b><br/>
				<small>Please make sure the PHP extensions listed below are installed</small>
				<div class="table-responsive">
					<table class="table table-striped table-hover table-bordered second my-3">
						<thead>
						<tr class="text-center">
							<th>Extension Settings</th>
							<th>Current settings</th>
							<th>Required Settings</th>
							<th>Status</th>
						</tr>
						</thead>
						<tbody>

							<?php foreach ($extension_list as $ext => $value):?>
								<tr <?php if ($value['status'] !== 'ON' && $value['required'] === 'ON'): ?>class="text-danger"<?php endif ?>>
									<td><?= $ext ?></td>
									<td class="text-center">
										<?= $value['status'] ?>
									</td>
									<td class="text-center">
										<?= $value['required'] ?>
									</td>
									<td class="text-center">
										<?php if ($value['status'] !== $value['required']): ?>
											<i class="fas fa-exclamation-triangle text-danger"></i>
										<?php else: ?>
											<i class="fas fa-check text-success"></i>
										<?php endif ?>
									</td>
								</tr>
							<?php endforeach;?>

						</tbody>
					</table>
				</div>
				<small>*** GD or GD2 or IMAGICK ***</small>
			</li>

			<li class="mt-3">
				<b>Kiểm tra quyền đọc/ ghi file và thư mục</b><br/>
				<small>Please make sure you have set the correct permissions on the files & directories list below</small>
				<div class="table-responsive">
					<table class="table table-striped table-hover table-bordered second my-3">
						<thead>
							<tr class="text-center">
								<th>Path</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody>

							<?php foreach ($permission_list as $path => $item):?>
								<tr <?php if ($item !== 'Writable'): ?>class="text-danger"<?php endif ?>>
									<td><?= $path ?></td>
									<td class="text-center"><?= $item ?></td>
								</tr>
							<?php endforeach;?>

						</tbody>
					</table>
				</div>
			</li>
		</ul>
	</div>

	<div class="my-2">
		<h2 data-bs-toggle="collapse" data-bs-target="#collapse_database" aria-expanded="false" aria-controls="collapse_database">2 - Database</h2>
		<ul class="list collapse" id="collapse_database">
			<li>
				<b>Tạo database, đường dẫn file sql:</b><br/>
				<small>Create a database on the MySQL server</small>
				<div class="bg-light my-2 p-2"><code>writable/database/</code></div>
			</li>
			<li>
				<b>Kiểm tra cài đặt, khai báo kết nối DB</b><br/>
				<small>Set-up connection</small>
				<div class="bg-light my-2 p-2 w-100">
					<code>
						//env<br/>
						database.default.hostname = localhost<br/>
						database.default.database = loitraitim<br/>
						database.default.username = root<br/>
						database.default.password =<br/>
						database.default.DBDriver = MySQLi<br/>
						database.default.DBPrefix =<br/>
					</code>
				</div>
			</li>
		</ul>
	</div>

	<div class="my-2">
		<h2 data-bs-toggle="collapse" data-bs-target="#collapse_composer" aria-expanded="false" aria-controls="collapse_composer">
			3 - Composer
		</h2>
		<ul class="list collapse" id="collapse_composer">
			<li>
				<b>Di chuyển đến thư mục root và chạy lệnh sau</b><br/>
				<small>Whenever there is a new release, then from the command line in your project root</small>
				<div class="bg-light my-2 p-2 w-100">
					<code>
						composer update
					</code>
				</div>
			</li>
		</ul>
	</div>

	<div class="my-2">
		<figure data-bs-toggle="collapse" data-bs-target="#collapse_git" aria-expanded="false" aria-controls="collapse_git">
			<blockquote class="blockquote">
				<h2>4 - GitHub</h2>
			</blockquote>
			<figcaption class="blockquote-footer">
				Token authentication requirements for Git operations
				<a href="https://github.blog/2020-12-15-token-authentication-requirements-for-git-operations/" target="_blank">Link</a>
			</figcaption>
		</figure>
		<ul class="list collapse" id="collapse_git">
			<li>
				<b>Loại bõ token cũ</b><br/>
				<small>Remove old token</small><br/>
				Về cơ bản thông tin đăng nhập của bạn đã hết hạn và bạn cần xóa nó đi:<br/>
				Chạy lại 2 lệnh command sau:
				<div class="bg-light my-2 p-2 w-100">
					<code>
						git config --global --unset credential.helper<br/>

						git config credential.helper store
					</code>
				</div>
				Sau khi nhập 2 lệnh trên thì nếu bạn muốn push là nó bắt bạn xác thưc lại - credentials.
			</li>
			<li class="my-3">
				<b>Tạo token github</b><br/>
				Đăng nhập vào github của bạn rồi vào link sau: <a href="https://github.com/settings/tokens" target="_blank">https://github.com/settings/tokens</a><br/>
				Bấm vô <strong>gennerate new token</strong><br/>
				Đặt đại cái tên rồi chọn vào 3 mục lớn: <strong>repo, workflow, gist</strong><br/>
				Sau đó bấm vô generate token.<br/>
				Sau đó bạn sẽ được 1 cái token tương ứng nhớ copy lại chứ bạn reload trang web phát là nó ẩn đi đó
			</li>
			<li>
				<b>Cập nhật github repo</b><br/>
				Nếu bạn clone thì sửa lại cái git thành dạng này:
				<div class="bg-light my-2 p-2 w-100">
					<code>
						git clone https://< token >@github.com/< username >/< repo >
					</code>
				</div>
				hoặc nếu bạn đã có repo thì dùng lệnh này để sửa lại cái repo
				<div class="bg-light my-2 p-2 w-100">
					<code>
						git remote set-url origin https://< token >@github.com/< username >/< repo >
					</code>
				</div>
			</li>
		</ul>
	</div>

	<div class="my-2">
		<h2 data-bs-toggle="collapse" data-bs-target="#collapse_env" aria-expanded="false" aria-controls="collapse_env">
			5 - Env
		</h2>
		<ul class="list collapse" id="collapse_env">
			<li>
				Đổi file env thành <code>.env</code><br/>
				Setting cơ bản
				<div class="bg-light my-2 p-2 w-100">
					<code>
						# CI_ENVIRONMENT = production<br/>
						CI_ENVIRONMENT = development<br/><br/>
						app.baseURL = 'https://localhost:8443/dev/catcool4/public/'<br/>
						app.indexPage = ''<br/><br/>
						# app.baseURL = ''<br/>
						# app.forceGlobalSecureRequests = false<br/><br/>
						#--------------------------------------------------------------------<br/>
						# DATABASE<br/>
						#--------------------------------------------------------------------<br/>
						database.default.hostname = localhost<br/>
						database.default.database = loitraitim<br/>
						database.default.username = root<br/>
						database.default.password =<br/>
						database.default.DBDriver = MySQLi<br/>
						database.default.DBPrefix =<br/><br/>
						# Google<br/>
						recaptcha3.key = 'fdsafdfdfgdg'<br/>
						recaptcha3.secret = 'dgadfgdfgfda'<br/>
						recaptcha3.scoreThreshold = 0.5
					</code>
				</div>
			</li>
		</ul>
	</div>

	<div class="my-2">
		<h2 data-bs-toggle="collapse" data-bs-target="#collapse_minify" aria-expanded="false" aria-controls="collapse_minify">
			- Minify -
		</h2>
		<ul class="list collapse" id="collapse_minify">
			<li>
				<a href="https://github.com/tdewolff/minify/tree/master/cmd/minify" target="_blank">Git</a><br/>
				Installation
				<div class="bg-light my-2 p-2 w-100">
					<code>
						mkdir $HOME/src<br/>
						cd $HOME/src<br/>
						git clone https://github.com/tdewolff/minify.git<br/>
						cd minify<br/>
						make install<br/><br/>

						//MacOS<br/>
						brew install tdewolff/tap/minify
					</code>
				</div>
			</li>
			<li>
				Usage<br/>
				Type<br/>
				<code>
					css     text/css<br/>
					htm     text/html<br/>
					html    text/html<br/>
					js      application/javascript<br/>
					json    application/json<br/>
					svg     image/svg+xml<br/>
					xml     text/xml<br/>
				</code>

				<br/><br/>
				Minify index.html to index-min.html:<br/>
				<code>
					$ minify -o index-min.html index.html
				</code>

				<br/><br/>
				Minify index.html to standard output (leave -o blank):<br/>
				<code>
					$ minify index.html
				</code>

				<br/><br/>
				Normally the mimetype is inferred from the extension, to set the mimetype explicitly:<br/>
				<code>
					$ minify --type=html -o index-min.tpl index.tpl
				</code>

				<br/><br/>
				You need to set the type or the mimetype option when using standard input:<br/>
				<code>
					$ minify --mime=application/javascript < script.js > script-min.js<br/>
					$ cat script.js | minify --type=js > script-min.js
				</code>

				<br/><br/>
				<b>Directories</b><br/>
				You can also give directories as input, and these directories can be minified recursively.<br/>
				Minify files in the current working directory to out/ (no subdirectories):<br/>
				<code>
					$ minify -o out/ *
				</code>

				<br/><br/>
				Minify files recursively in src/:<br/>
				<code>
					$ minify -r -o out/ src
				</code>

				<br/><br/>
				Minify only javascript files in src/:<br/>
				<code>
					$ minify -r -o out/ --match=\.js src
				</code>

				<br/><br/>
				<b>Concatenate</b><br/>
				When multiple inputs are given and the output is either standard output or a single file, it will concatenate the files together if you use the bundle option.<br/>
				Concatenate one.css and two.css into style.css:<br/>
				<code>
					$ minify -b -o style.css one.css two.css
				</code>

				<br/><br/>
				Concatenate all files in styles/ into style.css:<br/>
				<code>
					$ minify -r -b -o style.css styles
				</code>
				<br/><br/>
				You can also use cat as standard input to concatenate files and use gzip for example:<br/>
				<code>
					$ cat one.css two.css three.css | minify --type=css | gzip -9 -c > style.css.gz
				</code>

				<br/><br/>
				<b>Watching</b><br/>
				To watch file changes and automatically re-minify you can use the -w or --watch option.<br/>
				Minify style.css to itself and watch changes:<br/>
				<code>
					$ minify -w -o style.css style.css
				</code>

				<br/><br/>
				Minify and concatenate one.css and two.css to style.css and watch changes:<br/>
				<code>
					$ minify -w -o style.css one.css two.css
				</code>

				<br/><br/>
				Minify files in src/ and subdirectories to out/ and watch changes:<br/>
				<code>
					$ minify -w -r -o out/ src
				</code>

				<br/><br/>
				Run css custom.css to custom.min.css<br/>
				<code>
					minify -b -o public/themes/loitraitim/assets/css/custom.min.css public/themes/loitraitim/assets/css/custom.css<br/><br/>
				</code>
				Run js custom.js to custom.min.js<br/>
				<code>
					minify -b -o public/themes/loitraitim/assets//js/custom.min.js public/themes/loitraitim/assets//js/custom.js
				</code>
			</li>
		</ul>
	</div>

</div>
<footer class="container-fluid text-center bg-success py-3">
	<small class="mb-2">
		Page rendered in {elapsed_time} seconds<br/>
		Environment: <?= ENVIRONMENT ?>
	</small>

	<div class="copyrights">
		<small>Copyright © <?= date('Y') ?> CatCool. All rights reserved. Dashboard by Dat Le.</small>
	</div>

</footer>
	<script>
		function toggleMenu() {
			var menuItems = document.getElementsByClassName('menu-item');
			for (var i = 0; i < menuItems.length; i++) {
				var menuItem = menuItems[i];
				menuItem.classList.toggle("hidden");
			}
		}
	</script>

	<!-- -->

</body>
</html>

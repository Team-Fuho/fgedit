<?php
require_once($pluginpath . "/src/modify.php"); // shh, this is mongoer
add_action('admin_footer', 'media_selector_print_scripts');

function media_selector_print_scripts()
{

	$my_saved_attachment_post_id = get_option('media_selector_attachment_id', 0);

?><script type='text/javascript'>
		jQuery(document).ready(function($) {

			// Uploading files
			var file_frame;
			var wp_media_post_id = wp.media.model.settings.post.id; // Store the old id
			var set_to_post_id = <?php echo $my_saved_attachment_post_id; ?>; // Set this

			jQuery('#upload_image_button').on('click', function(event) {

				event.preventDefault();

				// If the media frame already exists, reopen it.
				if (file_frame) {
					// Set the post ID to what we want
					file_frame.uploader.uploader.param('post_id', set_to_post_id);
					// Open frame
					file_frame.open();
					return;
				} else {
					// Set the wp.media post id so the uploader grabs the ID we want when initialised
					wp.media.model.settings.post.id = set_to_post_id;
				}

				// Create the media frame.
				file_frame = wp.media.frames.file_frame = wp.media({
					title: 'Select a image to upload',
					button: {
						text: 'Use this image',
					},
					multiple: false // Set to true to allow multiple files to be selected
				});

				// When an image is selected, run a callback.
				file_frame.on('select', function() {
					// We set multiple to false so only get one image from the uploader
					attachment = file_frame.state().get('selection').first().toJSON();

					// Do something with attachment.id and/or attachment.url here
					$('#image-preview').attr('src', attachment.url).css('width', 'auto');
					$('#image_attachment_id').val(attachment.url);
					$('#attatchment').val(attachment.url);

					// Restore the main post ID
					wp.media.model.settings.post.id = wp_media_post_id;
				});

				// Finally, open the modal
				file_frame.open();
			});

			// Restore the main ID when the add media button is pressed
			jQuery('a.add_media').on('click', function() {
				wp.media.model.settings.post.id = wp_media_post_id;
			});
		});
	</script><?php

					}
					function
					attatchmentReplacement($src)
					{
						wp_enqueue_media();
						?><div class='image-preview-wrapper'>
		<img id='image-preview' src='<?php echo $src; ?>' style='max-width: 70%'>
	</div>
	<br>
	<input id="upload_image_button" type="button" class="button" value="<?php _e('Upload image'); ?>" /><?php
																																																		}
																																																		function fuho_dashgaledit()
																																																		{
																																																			add_submenu_page('fuho_gplug', 'Edit Gallery', 'Edit Gallery', 'manage_options', 'fuho_gplug_edit', 'fuho_gplug_edit_renderer');
																																																			add_thickbox();
																																																			?>
	<?php
																																																			$curlang = isset($_POST['slang']) ? $_POST['slang'] : 'vi';
																																																			$langs = [
																																																				"vi" => "Tiếng Việt",
																																																				"en" => "English",
																																																				"ru" => "Русский",
																																																				"cn" => "中文",
																																																				"jp" => "日本語",
																																																				"kr" => "한국어",
																																																				"fr" => "Français"
																																																			];
	?>
	<link rel="stylesheet" href="<?php echo plugins_url('../assets/galledit.css', __FILE__); ?>">
	<form method=POST class=galeform>
		<h1>Chỉnh sửa khu triển lãm</h1>
		<div class="form-group">
			<select name="slang">
				<?php
																																																			foreach ($langs as $key => $value) {
																																																				echo "<option value='$key' " . ($curlang == $key ? 'selected' : '') . ">$value</option>";
																																																			}
				?>
			</select>
			<button type=submit class="button button-primary">Đổi</button>
			<div class="button button-primary" onclick="fuho_epic()">+ Thêm ảnh</div>
			<script type="text/javascript">
	function filterAlert() {
		var url = window.location.href;
		var params = url.split("?");
		if (params.length > 1) {
			var params = params[1].split("&");
			var newParams = "";
			for (var i = 0; i < params.length; i++) {
				if (params[i].split("=")[0] != "alert") {
					newParams += params[i] + "&";
				}
			}
			if (newParams.length > 0) {
				newParams = newParams.substring(0, newParams.length - 1);
				window.location.href = url.split("?")[0] + "?" + newParams;
			} else {
				window.location.href = url.split("?")[0];
			}
		}
	}
	<?php
	if (isset($_GET["alert"])) {
		echo "alert('" . $_GET["alert"] . "');filterAlert()";
	}
	?>
</script>
		</div>
	</form>
	<div class="imgal" style="grid-template-columns: repeat(3, 1fr); opacity: 1;">
		<?php
																																																			$cur = fuho_conn()->find([], [
																																																				'projection' => [
																																																					'_id' => 1,
																																																					'src' => 1,
																																																					'date' => 1,
																																																					'vi' => 1
																																																				]
																																																			]);
																																																			foreach ($cur as $doc) {
																																																				// echo json_encode($doc);
																																																				$id = $doc['_id'];
																																																				$src = $doc->src;
																																																				$date = $doc->date;
																																																				$content = $doc->vi;
																																																				$title = $content->title;
																																																				$desc = $content->content;
																																																				// echo json_encode($content);
		?>
			<div class="gal" id="<?php echo $id; ?>" onclick="bsel('<?php echo $id; ?>')">
				<div>
					<span>
						<img id="img-<?php echo $id; ?>" src="<?php echo $src; ?>" alt="">
					</span>
					<div class="datgr">
						<h1 id="title-<?php echo $id; ?>"><?php echo $title; ?></h1>
						<p><?php echo gmdate("d/m/Y", intval($date)); ?></p>
						<p id="desc-<?php echo $id; ?>"><?php echo $desc; ?></p>
					</div>
				</div>
			</div>
		<?php
																																																			}
		?>
	</div>
	<!-- <div class="gal" id="gallitem5" onclick="bsel(5)">
			<div>
				<span>
					<img src="https://teamfuho.net/res/img/2021-08-12_01.31.16-min.jpg" alt="">
				</span>
				<div>
					<h1>Văn Miếu</h1>
					<p>12/08/2021</p>
					<p>Khuê Văn Các: Khuê Văn Các chính là biểu tượng của Văn chương, tượng trưng cho đất và trời. Đây cũng là biểu hiện rõ nét nhất của triết lý âm dương trong lối kiến trúc của di tích biểu tượng này.</p>
				</div>
			</div>
		</div> -->
	<div id="my-content-id" style="display:none;">
		<form class="dialogwrapper dillay" id=fuhoform action=/wp-content/plugins/ncct/function/edit.php method="post">
			<br>
			<?php
																																																			attatchmentReplacement("https://loopcentral.vn/uploads/thumbnail/217038a96b8e7e02aeadd633832d4fd8.jpg");
			?>
			<span>Tiêu đề ( <span class="react-lang"><?php
				echo $langs[$curlang];
			?></span>)</span>
			<input type="text" name="gall-title" id="etart">
			<span>Nội dung (<span class="react-lang"><?php
				echo $langs[$curlang];
			?></span>)</span>
			<textarea name="gall-cont" id="etarc" style="width:100%;height:126px;" oninput='if(this.value.includes("\"")){this.value=(op?this.value.replace("\"","“"):this.value.replace("\"","”"));op=!op}'></textarea>
			<input type="hidden" name="gall-id" id="etarid">
			<input type="hidden" name="lang" value="<?php echo $curlang ?>">
			<style>
				.btngr>button {
					margin-right: 5px !important;
				}
			</style>
			<div class="btngr">
				<button type=submit name=mod class="button button-primary" id=upd>Cập nhật</button>
				<button type=submit name=del class="button button-primary" id=del>Xóa</button>
			</div>
			<input type='hidden' name='attatchment' id='attatchment' value=''>
		</form>
	</div>

	<a id="diag" href="#TB_inline?&width=600&height=550&inlineId=my-content-id" class="thickbox hid">View my inline content!</a>
	<script type="text/javascript">
		const diagprim = document.getElementById("diag"),
			etart = document.getElementById("etart"),
			etarc = document.getElementById("etarc"),
			etoet = document.getElementById('attatchment'),
			etid = document.getElementById("etarid"),
			form = document.getElementById("fuhoform");
		let op=true

		// if have alert param, filter it and redirect, do not remove others

		function bsel(i) {
			console.log(i);
			prepcontent(i);
		}

		function fuho_epic() {
			const delbut = document.getElementById("del"),
				updbut = document.getElementById("upd")
			// change image to broken image
			// set title and content to empty
			// set other field to empty
			// add that to the start
			// bruh why its keep reloading
			// dunno 
			etart.value = "";
			etarc.value = "";
			etid.value = "";
			etoet.value = "";
			etart.placeholder = "Tiêu đề";
			etarc.placeholder = "Nội dung";
			delbut.style.display = "none";
			updbut.innerHTML = "Thêm";
			form.action = "/wp-content/plugins/ncct/function/add.php";
			diagprim.click(); // this sus
		}

		function prepcontent(i) {
			const delbut = document.getElementById("del"),
				updbut = document.getElementById("upd")
			const tarim = document.getElementById('image-preview')
			const src = document.getElementById("img-" + i).src

			const dtit = document.getElementById('title-' + i);
			const dcont = document.getElementById('desc-' + i);

			updbut.innerHTML = "Cập nhật";
			delbut.style.display = "block";
			tarim.src = src;
			etoet.value = src;
			etart.value = dtit.innerHTML;
			etarc.value = dcont.innerHTML;
			etid.value = i;
			form.action = "/wp-content/plugins/ncct/function/edit.php";
			diagprim.click()
		}
	</script>
	<style>
		.btngr {
			display: flex;
		}

		.btngr>button {
			margin-right: 10px;
			border-radius: .5vh;
		}
	</style>
<?php
																																																		}

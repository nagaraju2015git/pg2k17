<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="format-detection" content="telephone=no" />
		<title>PainlessGift</title>
		<style type="text/css">
			h1,h2,h3,h4,p{margin:0px;}
			.btn{background-color: #b0741d; padding: 8px 15px; border-radius: 3px; color: #fff; font-size: 13px; text-decoration: none; display: inline-block;}
			p{font-size:14px;margin-bottom:5px;line-height: 20px;}
			@media only screen and (max-width: 480px){
				table[id=maintable]{width:100%;}
				center{padding:10px;}
			}
		</style>
		
	</head>
	<body bgcolor="#E1E1E1" leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">

		<center style="background-color:#E1E1E1;padding:20px;font-family:Verdana,sans-serif;">
			<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="maintable" style="border: 1px solid #fff; background-color: #fff;padding: 10px; border-radius: 5px;max-width:500px;">
				<tr>
					<td style="border-bottom: 1px solid #ddd;text-align:center; padding-bottom: 15px;padding-top: 5px;"> <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url('assets/images/logo_large.png'); ?>" style="max-width:100%;max-height:70px;"></a> </td>
				</tr>
				<tr>
					<td style="padding: 20px 10px;"> 
						<p>Dear <b><?php echo $name; ?></b>,</p>
						<p>Product information has been updated for below products,</p><br>
						
						<?php foreach($products as $p){ ?>
						<div style="width: calc(50% - 15px);display:inline-block;margin-right: 10px;">
							<div class="product" style="border-radius: 3px;background-color: #DDD; border: 1px solid #CCC; border-bottom-color: #CCC; display: inline-block; position: relative; width: 100%; margin-bottom: 10px; box-shadow: 1px 1px 1px #ddd;">
 								<a href="<?php echo $p->link; ?>" target="_blank">
									<div class="img" style="overflow: hidden; width: 100%; height: 200px; text-align: center; position: relative;"> 										
										<img src="<?php echo $p->image; ?>" style="max-width: 90%; max-height: 90%; position: absolute; top: 50%; left: 50%; -ms-transform: translate(-50%, -50%); -webkit-transform: translate(-50%, -50%); transform: translate(-50%, -50%);">
									</div>
									<div class="content" style=" padding: 7px 5px;text-align: center;font-size: 15px; background-color: #fff; border-top: 1px solid #ccc;">
										<div class="title" style="color: #555;overflow: hidden; white-space: nowrap; padding: 0px 5px;text-overflow: ellipsis;font-weight: bold; font-size: 14px;"><?php echo $p->name; ?></div>
										<div class="price" style="color: #0c1acc; font-weight: bold;">$<?php echo $p->price; ?></div>
									</div>
								</a>
							</div>
						</div>
						<?php } ?>
					
					</td>	
				</tr>
				<tr>
					<td style="padding: 0px 10px 10px;"> 
						<p>Thanks,<br>
						The PainlessGift Team.</p>
					</td>	
				</tr>
			</table>
		</center>
		
	</body>
</html>

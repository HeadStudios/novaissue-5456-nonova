<!DOCTYPE html>
<html>
<head>
</head>
<body>
<script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>

<p>Hey <?php echo $details['name']; ?>,</p>
<p>
<?php 
//
     //$body = str_replace('{{paylink}}', $paylink, $details['body']);
     //$body = str_replace('{{payopt}}', $payopt, $body);
     //{!payopt}
    $body = $details['body'];
     // Create a new Parsedown instance
     $parsedown = new Parsedown();
 
     // Parse and convert the $body variable to HTML
     echo $parsedown->text($body);
 ?>
</p>
    <br>
<div><table style="color: rgb(34, 34, 34);font-family: Arial, Helvetica, sans-serif;font-size: small;background-color: rgb(255, 255, 255);direction: ltr;border-radius:0px;"><tbody><tr><td style="font-family: Roboto, RobotoDraft, Helvetica, Arial, sans-serif;"><table cellpadding="0" cellspacing="0" style="font-family: Arial;line-height: 1.15;color: rgb(0, 0, 0);"><tbody><tr>
<td style="font-family: Roboto, RobotoDraft, Helvetica, Arial, sans-serif;vertical-align: top;padding-right:14px;"><table cellpadding="0" cellspacing="0" style="width: 65px;"><tbody><tr><td><img src="https://d36urhup7zbd7q.cloudfront.net/36569729-7d15-47dc-a80c-77697c3aaaf2/my_photo.format_png.resize_200x.jpeg" height="65" width="65" style="width: 65px;vertical-align: initial;border-radius:0px;display: block;height: 65px;"></td></tr></tbody></table></td>
<td height="1" width="0" style="font-family: Roboto, RobotoDraft, Helvetica, Arial, sans-serif;width: 0px;border-right:2px solid rgb(189, 189, 189);height: 1px;font-size: 1pt;">&nbsp;</td>
<td valign="top" style="font-family: Roboto, RobotoDraft, Helvetica, Arial, sans-serif;padding-left:14px;vertical-align: top;"><table cellpadding="0" cellspacing="0"><tbody>
<tr><td style="line-height: 1.2;padding-bottom:12px;">
<span style="font-family: Arial;font-weight: bold;"><span style="color: rgb(100, 100, 100);font-size: 15.6px;">Kosta Kondratenko</span></span><br><span style="font-size: 13.2px;letter-spacing: 0px;font-family: Arial;font-weight: bold;color: rgb(100, 100, 100);">Internet Aficionado,&nbsp;</span><span style="font-size: 13.2px;letter-spacing: 0px;font-family: Arial;font-weight: bold;color: rgb(100, 100, 100);">Head Studios</span>
</td></tr>
<tr><td style="line-height: 0;"><table cellpadding="0" cellspacing="0"><tbody>
<tr><td><table cellpadding="0" cellspacing="0"><tbody><tr>
<td style="line-height: 0px;padding-bottom:6px;"><table cellpadding="0" cellspacing="0" style="line-height: 14px;font-size: 12px;font-family: Arial;"><tbody><tr><td style="font-size: 12px;"><a href="tel:+6412+826+569" target="_blank" style="color: rgb(17, 85, 204);font-size: 12px;"><span style="line-height: 1.2;color: rgb(33, 33, 33);white-space: nowrap;font-size: 12px;">+6412 826 569</span></a></td></tr></tbody></table></td>
<td style="line-height: 0px;padding-bottom:6px;"><table cellpadding="0" cellspacing="0" style="line-height: 14px;font-size: 12px;font-family: Arial;"><tbody><tr>
<td style="font-family: Roboto, RobotoDraft, Helvetica, Arial, sans-serif;padding-right:6px;padding-left:6px;"><span style="font-family: Arial;font-weight: bold;font-size: 12px;color: rgb(33, 33, 33);vertical-align: 2px;">|</span></td>
<td style="font-size: 12px;"><a href="mailto:kosta@headstudios.com.au" target="_blank" style="color: rgb(17, 85, 204);font-size: 12px;"><span style="line-height: 1.2;color: rgb(33, 33, 33);white-space: nowrap;font-size: 12px;">kosta@headstudios.com.au</span></a></td>
</tr></tbody></table></td>
</tr></tbody></table></td></tr>
<tr><td><table cellpadding="0" cellspacing="0"><tbody><tr><td style="line-height: 0px;padding-bottom:6px;"><table cellpadding="0" cellspacing="0" style="line-height: 14px;font-size: 12px;font-family: Arial;"><tbody><tr><td style="font-size: 12px;"><a href="https://headstudios.com.au/" target="_blank" style="color: rgb(17, 85, 204);font-size: 12px;"><span style="line-height: 1.2;color: rgb(33, 33, 33);white-space: nowrap;font-size: 12px;">https://headstudios.com.au/</span></a></td></tr></tbody></table></td></tr></tbody></table></td></tr>
</tbody></table></td></tr>
</tbody></table></td>
</tr></tbody></table></td></tr></tbody></table></div>
</div>
</body>
</html>

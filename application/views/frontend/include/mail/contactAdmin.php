<strong>Thông tin liên hệ:</strong> <br />
- Họ tên: <?=$detailContact['cus_fullname']?> <br />
- Điện thoại: <a href="tel:<?=$detailContact['cus_phone']?>"><?=$detailContact['cus_phone']?></a><br />
- Email: <a href="mailto:<?=$detailContact['cus_email']?>"><?=$detailContact['cus_email']?></a><br />
- Địa chỉ: <?=$detailContact['cus_address']?><br />
- Tiêu đề: <?=$detailContact['title']?><br/>
- Nội dung: <?=$detailContact['content']?>

<br />
<p style="font-style: italic;">Quản trị viên có thể quản lý liên hệ và cập nhật trạng thái liên hệ tại: <a style="font-weight: bold;" href="<?=base_url()?>admin/contact/readContact/<?=$detailContact['id']?>">TẠI ĐÂY</a></p>
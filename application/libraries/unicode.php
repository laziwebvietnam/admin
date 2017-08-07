<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
class unicode
{
	function change($str)
	{
		$str = trim($str);
		if ($str=="") return "";
		$str = str_replace('"','',$str);
		$str = str_replace("'",'',$str);
		$str = $this->unicode2none($str);
		//$str = mb_convert_case($str,MB_CASE_TITLE,'utf-8');
		$str = str_replace(' ','-',$str);
		$str = str_replace('&','-',$str);
		$str = str_replace(';','-',$str);
		$str = str_replace('(','-',$str);
		$str = str_replace(')','-',$str);
		$str = str_replace('/','-',$str);
		$str = str_replace('.','-',$str);
		$str = str_replace('!','-',$str);
		$str = str_replace('@','-',$str);
		
		return $str;
	}
	public function check($str)
	{
		$tukhoa = array('','=','^','$','--','+','<','>','.',',','*','&','(',')','?','#','@','!','~','`','"','|','%','chr(', 'chr=', 'chr%20', '%20chr', 'wget%20', '%20wget', 'wget(', 'cmd=', '%20cmd', 'cmd%20', 'rush=', '%20rush', 'rush%20', 'union%20', '%20union', 'union(', 'union=', 'echr(', '%20echr', 'echr%20', 'echr=', 'esystem(', 'esystem%20', 'cp%20', '%20cp', 'cp(', 'mdir%20', '%20mdir', 'mdir(', 'mcd%20', 'mrd%20', 'rm%20', '%20mcd', '%20mrd', '%20rm', 'mcd(', 'mrd(', 'rm(', 'mcd=', 'mrd=', 'mv%20', 'rmdir%20', 'mv(', 'rmdir(', 'chmod(', 'chmod%20', '%20chmod', 'chmod(', 'chmod=', 'chown%20', 'chgrp%20', 'chown(', 'chgrp(', 'locate%20', 'grep%20', 'locate(', 'grep(', 'diff%20', 'kill%20', 'kill(', 'killall', 'passwd%20', '%20passwd', 'passwd(', 'telnet%20', 'vi(', 'vi%20', 'insert%20into', 'select%20', 'nigga(', '%20nigga', 'nigga%20', 'fopen', 'fwrite', '%20like', 'like%20', '$_request', '$_get', '$request', '$get', '.system', 'HTTP_PHP', '&aim', '%20getenv', 'getenv%20', 'new_password', '&icq','/etc/password','/etc/shadow', '/etc/groups', '/etc/gshadow', 'HTTP_USER_AGENT', 'HTTP_HOST', '/bin/ps', 'wget%20', 'uname\x20-a', '/usr/bin/id', '/bin/echo', '/bin/kill', '/bin/', '/chgrp', '/chown', '/usr/bin', 'g\+\+', 'bin/python', 'bin/tclsh', 'bin/nasm', 'perl%20', 'traceroute%20', 'ping%20', '.pl', '/usr/X11R6/bin/xterm', 'lsof%20', '/bin/mail', '.conf', 'motd%20', 'HTTP/1.', '.inc.php', 'config.php', 'cgi-', '.eml', 'file\://', 'window.open', '<SCRIPT>', 'javascript\://','img src', 'img%20src','.jsp','ftp.exe', 'xp_enumdsn', 'xp_availablemedia', 'xp_filelist', 'xp_cmdshell', 'nc.exe', '.htpasswd', 'servlet', '/etc/passwd', 'wwwacl', '~root', '~ftp', '.js', '.jsp', 'admin_', '.history', 'bash_history', '.bash_history', '~nobody', 'server-info', 'server-status', 'reboot%20', 'halt%20', 'powerdown%20', '/home/ftp', '/home/www', 'secure_site, ok', 'chunked', 'org.apache', '/servlet/con', '<script', '/robot.txt' ,'/perl' ,'mod_gzip_status', 'db_mysql.inc', '.inc', 'select%20from', 'select from', 'drop%20', '.system', 'getenv', 'http_', '_php', 'php_', 'phpinfo()', '<?php', '?>', 'sql=');
		$kiemtra = str_replace($tukhoa, '[]', $str);
		if ($str != $kiemtra){
			return FALSE;
		}
		return TRUE;
	}
	function unicode2none($str)
	{
		if(!$str) return false;
		$unicode = array(
			'a'=>'á|à|ả|ã|ạ|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ',
			'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ằ|Ẳ|Ẵ|Ặ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
			'd'=>'đ',
			'D'=>'Đ',
			'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
			'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
			'i'=>'í|ì|ỉ|ĩ|ị',
			'I'=>'Í|Ì|Ỉ|Ĩ|Ị',
			'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
			'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
			'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
			'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
			'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
			'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ'
			);
		foreach($unicode as $khongdau=>$codau){
			$arr=explode("|",$codau);
			$str = str_replace($arr,$khongdau,$str);
		}
		return $str;
	}
	function unicode2database($str)
	{
		$str = str_replace('&aacute;','á',$str);
		$str = str_replace('&agrave;','à',$str);
		$str = str_replace('&atilde;','ã',$str);
		$str = str_replace('&acirc;','â',$str);
		$str = str_replace('&Aacute;','Á',$str);
		$str = str_replace('&Agrave;','À',$str);
		$str = str_replace('&Atilde;','Ã',$str);
		$str = str_replace('&Acirc;','Â',$str);
		$str = str_replace('&eacute;','é',$str);
		$str = str_replace('&egrave;','è',$str);
		$str = str_replace('&ecirc;','ê',$str);
		$str = str_replace('&Eacute;','É',$str);
		$str = str_replace('&Egrave;','È',$str);
		$str = str_replace('&Ecirc;','Ê',$str);
		$str = str_replace('&uacute;','ú',$str);
		$str = str_replace('&ugrave;','ù',$str);
		$str = str_replace('&Uacute;','Ú',$str);
		$str = str_replace('&Ugrave;','Ù',$str);
		$str = str_replace('&oacute;','ó',$str);
		$str = str_replace('&ograve;','ò',$str);
		$str = str_replace('&otilde;','õ',$str);
		$str = str_replace('&ocirc;','ô',$str);
		$str = str_replace('&Oacute;','Ó',$str);
		$str = str_replace('&Ograve;','Ò',$str);
		$str = str_replace('&Otilde;','Õ',$str);
		$str = str_replace('&Ocirc;','Ô',$str);
		$str = str_replace('&yacute;','ý',$str);
		$str = str_replace('&Yacute;','Ý',$str);
		$str = str_replace('&igrave;','ì',$str);
		$str = str_replace('&Igrave;','Í',$str);
		$str = str_replace('&iacute;','í',$str);
		return $str;
	}
	
	public function TimeArr()
	{
		$start = strtotime('00:01');
		$end = strtotime('23:59');
		$arrTime =  array();
		$i = 0;
		while($i!=50)
		{
			$temp =  date("H:s",rand($start,$end));		
			if(in_array($temp,$arrTime))
			{
				$i--;
				continue;
			}
			else
			{
				$arrTime[] = $temp;
			}			
			$i++;
		}
		return $arrTime;
	}
	function is_valid_url($url)
	{
		if (!($url = @parse_url($url)))
		{
			return false;
		}
	 
		$url['port'] = (!isset($url['port'])) ? 80 : (int)$url['port'];
		$url['path'] = (!empty($url['path'])) ? $url['path'] : '/';
		$url['path'] .= (isset($url['query'])) ? "?$url[query]" : '';
	 
		if (isset($url['host']) AND $url['host'] != @gethostbyname($url['host']))
		{
			if (PHP_VERSION >= 5)
			{
				$headers = @implode('', @get_headers("$url[scheme]://$url[host]:$url[port]$url[path]"));
			}
			else
			{
				if (!($fp = @fsockopen($url['host'], $url['port'], $errno, $errstr, 10)))
				{
					return false;
				}
				fputs($fp, "HEAD $url[path] HTTP/1.1\r\nHost: $url[host]\r\n\r\n");
				$headers = fread($fp, 4096);
				fclose($fp);
			}
			return (bool)preg_match('#^HTTP/.*\s+[(200|301|302)]+\s#i', $headers);
		}
		return false;
	}
	public function static_url()
	{
		$tmp = base_url();
		if($tmp != 'http://localhost/larige/')
		{
			if(($tmp=='http://larige.com/' || $tmp=='https://larige.com/') && $this->is_valid_url('http://static.larige.com/config.php')==true)
			{
				return 'http://static.larige.com/';
			}
			else if($tmp=='http://larige.vn/' && $this->is_valid_url('http://static.larige.vn/config.php')==true)
			{
				return 'http://static.larige.vn/';
			}
			else
			{
				return $tmp.'statics/';
			}
		}
		else
		{
			return $tmp.'statics/';
		}
	}
}
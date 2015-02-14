<?php
function encrypt($id_)
{
	$id_2=($id_ * 1925.010325);
	$code_ = base64_encode($id_2);
	return $code_;
}

function decrypt($id_)
{
	$decode = base64_decode($id_);
					$decode_ = ($decode / 1925.010325);
					$array_ = explode(".", $decode_);
					if(isset($array_['1']) || $decode_ == 0)
					{
						header("location:index.php");
						
					}else
					{
						return $decode_;
					}
}

?>
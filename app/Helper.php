<?php

use Illuminate\Support\Facades\Route;
class Helper{
	
	// public static function Active($path, $class = "active treeview")
	// {
	// 	return Request::path() === $path ? $class : "";
	// }

	//Breadcrumb helper function
	public static function Currentdirectory()
	{
		return Request::path();
	}

	

	public static function is_active($uri = "/")
	{
		return strstr(Request::path(),$uri);
	}

	public static function date_format($time,$format ="M-d-Y  h:i a")
	{
		return $time =="0000-00-00 : 00:00:00" ? "" : date($format,strtotime($time));
		
	}

	public static function date_db($time)
	{
		return $time =="0000-00-00 00:00:00" ? "" : date(env('DATE_DB','Y-m-d'),strtotime($time));
		//return $time == "0000-00-00 00:00:00" ? "" : date(env('DATE_DB',"Y-m-d"),strtotime($time));
	}

	public static function Amount($number)
	{
		return number_format($number,2,".",",");
	}

	public static function trash($position,$module)
	{
		// if(in_array($position,['administrator','manager']))
		// 	{
		// 		return  true;
		// 	}
		$route = route('Backend.'.$module.'.trash');
		if(in_array($position,['administrator','manager']))
		{
			echo "<li> <a href='{$route}'><i class='fa fa-circle-o'></i>Trash</a></li>";
		}
	}
	
	


}
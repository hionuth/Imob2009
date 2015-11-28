<?php

function redirect_to($location = NULL) {
	if ($location != NULL) {
		header("Location: {$location}");
	}
}

function output_message($message="") {
	if (!empty($message)) {
		return "<p class=\"message\">{$message}</p>";
	}
	else {
		return "";
	}
}

function __autoload($class_name) {
	$class_name = strtolower($class_name);
	$path = LIB_PATH.DS."{$class_name}.php";
	if (file_exists($path)) {
		require_once($path);
	}
	else {
		die("Fisierul {$class_name}.php nu a fost gasit");
	}
}

function include_layout_template($template="") {
	include(SITE_ROOT.DS.'layout'.DS.$template);	
}

function put_text_item($label,$varname,$size="") {
	global ${$varname};
	$item="<tr><td class='label'>".$label.":</td>";
	$item=$item."<td><input type='text' size='{$size}' name='".$varname."' value='".htmlentities(${$varname})."' /></td></tr>";
	return $item;
}
function put_text_item2($label,$varname,$size="",$align="") {
	global ${$varname};
	$item="<tr><td class='label'>".$label.":</td>";
	$item=$item."<td><input type='text' style=\"width:{$size}px;text-align:{$align};\" name='".$varname."'/></td></tr>";
	return $item;
}

function put_check_item($label,$varname,$checked=0,$disabled=0) {
	global ${$varname};
	$item="<tr><td class='label'>".$label.":</td>";
	if (!isset(${$varname})) {${$varname}="";}
	$item=$item."<td><input type='checkbox' name='".$varname."' value=1 ".htmlentities(((${$varname}>0)||(($checked>0)&&($checked!=3))) ? "checked='checked'" : "")." ".(($disabled==1) ? "disabled=\"disabled\"":"")."/></td></tr>";
	return $item;
}

function put_text_item_obj($label,$varname,$size="",$align="") {
	global ${$varname};
	$field=substr($varname,2);
	if (substr($varname,0,2)=="Ap") {
		$obiect="apartament";
	}
	if (substr($varname,0,2)=="Of") {
		$obiect="oferta";
	}
	global ${$obiect};
	$item="<tr><td class='label'>".$label.":</td>";
	$item=$item."<td><input type='text' style=\"width:{$size}px;text-align:{$align};\" name='".$varname."' value='".htmlentities(${$obiect}->$field)."' /></td></tr>";
	return $item;
}

function put_check_item_obj($label,$varname) {
	global ${$varname};
	$field=substr($varname,2);
	if (substr($varname,0,2)=="Ap") {
		$obiect="apartament";
	}
	if (substr($varname,0,2)=="Of") {
		$obiect="oferta";
	}
	global ${$obiect};
	$item="<tr><td class='label'>".$label.":</td>";
	$item=$item."<td><input type='checkbox' name='".$varname."' value=1 ".htmlentities( (${$obiect}->$field>0)&&(${$obiect}->$field!=3) ? "checked='checked'" : "")." /></td></tr>";
	return $item;
}

function convert_date($data,$mode=0) {
	if ($data=="0000-00-00") return "";
	if ($mode==1){
		$dataArr=explode("/",$data);
		return implode("-",array_reverse($dataArr,false));
	}
	else {
		$dataArr=explode("-",$data);
		return implode("/",array_reverse($dataArr,false));
	}
}

function strip_digits($text="")
{
	$pattern = '/[^0-9]*/';
	return preg_replace($pattern,"", $text);
}

function tip_proprietate($var){
	switch ($var){
		case 0: return "apartament"; break;
		case 1: return "apartament in vila"; break;
		case 2: return "casa"; break;
		case 3: return "teren"; break;
		case 4: return "spatiu"; break;
	}
}
?>
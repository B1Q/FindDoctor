<?php
/**
 * Created by PhpStorm.
 * User: Mohamed Hosny
 * Date: 4/2/2019
 * Time: 8:34 AM
 */

class TemplateMaster
{
	private static $smarty;
	private static $includedAssigns;

	const HEAD_PATH = "template/head";
	const HEADER_PATH = "template/header";
	const FOOTER_PATH = "template/footer";
	const SIDEBAR_PATH = "template/sidebar";

	public static function InitializeConfig($config)
	{
		self::$includedAssigns = $config['site'];
	}

	public static function LoadTemplate($path, $data = [])
	{
		$templateName = $path . ".tpl";
		if (file_exists(VIEWSPATH . $templateName)) { // load template
			if (!isset($smarty)) {
				$smarty = new Smarty();
				$smarty->setTemplateDir(VIEWSPATH);
				$smarty->setCacheDir(SMARTYCACHE);
				$smarty->setCompileDir(SMARTYCOMPILED);

				$smarty->debugging = FALSE;
				$smarty->caching = FALSE;

				foreach ($data as $key => $value) {
//					if (is_array($value)) {
//						foreach ($value as $dkey => $dvalue)
//							$smarty->assign($dkey, $dvalue);
//					}
					$smarty->assign($key, $value);
				}

				foreach (self::$includedAssigns as $key => $value)
					$smarty->assign($key, $value);

				TemplateMaster::$smarty = $smarty; // in case we need to access it later
			}
			self::$smarty->display($templateName);
		}
	}

	public static function DisplayWithChildren($path, $data = [], $header = TRUE, $footer = TRUE, $sidebar = TRUE)
	{
		//self::LoadTemplate(TemplateMaster::HEAD_PATH, $data);
//
//		if ($header)
//			self::LoadTemplate(TemplateMaster::HEADER_PATH, $data);
//		if ($sidebar)
//			self::LoadTemplate(TemplateMaster::SIDEBAR_PATH, $data);

		$data['sessionId'] = Session::$Instance->SessionId ?? 0;

		self::LoadTemplate($path, $data);


		/* Footer */
//		$data['FooterEnabled'] = $footer;
//		self::LoadTemplate(TemplateMaster::FOOTER_PATH, $data);
	}
}
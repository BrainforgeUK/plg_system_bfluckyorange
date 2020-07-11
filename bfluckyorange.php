<?php
/**
 * @package    Lucky Orange for Joomla!
 * @author    https://www.brainforge.co.uk
 * @copyright  (C) 2020 Jonathan Brain. All rights reserved.
 * @license    GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

use Joomla\CMS\Factory;
use Joomla\CMS\Helper\UserGroupsHelper;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\User\UserHelper;

defined('_JEXEC') or die('Restricted access');

class plgSystemBfluckyorange extends CMSPlugin
{
	public function onBeforeRender()
	{
		$app = Factory::getApplication();

		if ($app->isClient('administrator')) {
			return;
		}

		$tmpl = $app->input->get('tmpl');
		if (!empty($tmpl))
		{
			// Not required for tmpl==component i.e. popups
			return;
		}

		$user = Factory::getUser();
		if ($user->get('isRoot'))
		{
			return;
		}

		/*
		 * 	Original source from Lucky Orange - use of cloudfront seems to be popular
		 *	$wjs = '("https:" == document.location.protocol ? "https://ssl" : "http://cdn") + ".luckyorange.com/w.js"';
		 */
		$wjs = '"https://d10lpsik1i8c69.cloudfront.net/w.js"';

		$js = '
window.__lo_site_id = "' . trim($this->params->get('siteid')) . '";

(function() {
    var wa = document.createElement("script");
    wa.type = "text/javascript";
    wa.async = true;
    wa.src = ' . $wjs . ';
    var s = document.getElementsByTagName("script")[0];
    s.parentNode.insertBefore(wa, s);
  })();
';

		Factory::getDocument()->addScriptDeclaration($js);
	}
}

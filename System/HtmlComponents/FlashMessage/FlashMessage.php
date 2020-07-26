<?php
namespace System\HtmlComponents\FlashMessage;
use System\Session\Session;

class FlashMessage
{
	public static function show()
	{
		$html = '';
		if (Session::hasFlash('error')) {
			$html .= '<p class="alert alert-danger">';
		    $html .= '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
		    $html .= Session::getFlash('error');
		    $html .= '</p>';
		    echo $html;
		    unset($_SESSION['flash_error']);

		} elseif (Session::hasFlash('success')) {
			$html .= '<p class="alert alert-success">';
		    $html .= '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
		    $html .= Session::getFlash('success');
		    $html .= '</p>';
		    echo $html;
		    unset($_SESSION['flash_success']);
		}
	}
}

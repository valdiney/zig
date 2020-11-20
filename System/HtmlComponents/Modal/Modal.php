<?php
namespace System\HtmlComponents\Modal;

class Modal
{
    public static function start(Array $attributes)
    {
        echo '<div id="'.$attributes["id"].'" class="modal fade" role="dialog">';
        echo '<div class="modal-dialog '.$attributes['width'].'">';
        echo '<div class="modal-content">';
        echo '<div class="modal-header">';
        echo '<h4 class="modal-title" style="margin-top:0;padding-top:0">'.$attributes['title'].'</h4>';
        echo '<button type="button" class="close" data-dismiss="modal">&times;</button>';
        echo '</div>';
        echo '<div class="modal-body into-modal" id="scroll-wrap">';
    }

    public static function stop()
    {
        echo '</div>';
        echo '<div class="modal-footer">';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }

    public static function button(Array $attributes)
    {
        echo 'data-toggle="modal" data-backdrop="static" data-target="#'.$attributes['id'].'"';
    }
}

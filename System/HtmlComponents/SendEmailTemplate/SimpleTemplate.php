<?php
namespace System\HtmlComponents\SendEmailTemplate;
class SimpleTemplate
{
  public static function template(array $data)
  {
    $title = $data['title'];
    $bodyMessage = utf8_decode($data['bodyMessage']);

    $applicationHost = getenv('APPLICATION_HOST');
    return "
        <body style='background:#f5f5f5;font-family:arial;padding-bottom:20px;'>
            <div style='width:600px;background:#f5f5f5;padding:10px;margin:0 auto'>
                <div>
                    <center><h1 style='font-family:arial;color:#666666'>{$title}</h1></center>
                </div>
                <div style='width:500px;background:white;min-height:100px;margin:0 auto;padding:20px;color:#666666'>
                <center>
                    {$bodyMessage}
                </center>
                </div>
            </div>

            <div>
                <center><h4 style='font-family:arial;color:#999999'>{$applicationHost}</h4></center>
            </div>
        </body>";
    }
}

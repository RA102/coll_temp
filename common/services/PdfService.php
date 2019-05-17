<?php

namespace common\services;

use kartik\mpdf\Pdf;

class PdfService
{
    /**
     * @param string $content
     * @param string $title
     * @return Pdf
     */
    public function generate(string $content, string $title)
    {
        $options = [
            'fontDir'  => \Yii::getAlias('@frontend/web/fonts'),
            'fontdata' => [
                'timesnewroman' => [
                    'R' => 'timesnewroman.ttf',
                ]
            ],
        ];

        return new Pdf([
            'mode'         => Pdf::MODE_UTF8,
            'orientation'  => Pdf::ORIENT_PORTRAIT,
            'destination'  => Pdf::DEST_BROWSER,
            'content'      => $content,
            'marginLeft'   => 10,
            'marginRight'  => 10,
            'marginTop'    => 10,
            'marginBottom' => 15,
            'cssFile'      => '@frontend/web/css/print.css',
            'options'      => $options,

            'methods' => [
                'SetTitle' => $title,
            ]
        ]);
    }
}
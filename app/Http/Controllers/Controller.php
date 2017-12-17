<?php

namespace GL\Http\Controllers;

use GL\Http\Responses\RespondsJson;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, RespondsJson;

    /**
     * find and sane page and size parameters from request (for pagination)
     *
     * @param Request $request
     * @param array   $options configurable options, keys including:
     *                         - defaultSize    (optional) the default page size - if there's no page size or
     *                                          an invalid one is provided, this default value will be applied
     *                                          (default: 120)
     *                         - maxPageSize    (optional) the max acceptable page size (default to the value of
     *                                          the defaultSize option)
     *                         - pageParamName  (optional) request param name for page number/index (default: 'page')
     *                         - sizeParamName  (optional) request param name for size (default: 'size')
     *
     * @return array a two-element array, with the first element being the page number/index
     */
    protected function sanePageAndSize(Request $request, array $options = [])
    {
        $options = array_merge($options, [
            'defaultSize'   => $this->getDefaultPageSize(),
            'maxPageSize'   => $this->getDefaultPageSize(),
            'pageParamName' => 'page',
            'sizeParamName' => 'size'
        ]);

        // find page and size from request and sane them
        $page = $this->sanePage($request->input($options['pageParamName']));

        // sane size
        $size = $request->input($options['sizeParamName'], $options['defaultSize']);
        if (!is_numeric($size)) {
            $size = $options['defaultSize'];
        } else {
            // page size should be with the range of (0, maxPageSize]
            if (!$size || $size <= 0 || $size > $options['maxPageSize']) {
                $size = min($options['defaultSize'], $options['maxPageSize']);
            }
        }

        return [$page, $size];
    }

    protected function sanePage($page) {
        // page number/index should start from 1 (not 0)
        if (!$page || $page <= 0 || !is_numeric($page)) {
            $page = 1;
        }

        return $page;
    }

    protected function getDefaultPageSize() {
        return 500;
    }

    /**
     * Validate given uuid or uuids
     *
     * @param $id
     * @return array
     * @throws \Exception
     */
    protected function validateUuid($id)
    {
        if (!is_array($id)) {
            return $this->ensureUuidFormat($id);
        }

        if (empty($id)) {
            throw new \Exception('no uuid');
        }

        foreach ($id as $item) {
            $this->ensureUuidFormat($item);
        }

        return array_values(array_unique($id));
    }

    private function ensureUuidFormat($id)
    {
        if (!Uuid::isValid($id)) {
            throw new \Exception('id is invalid');
        }

        return $id;
    }

    /**
     * output table of html
     *
     * @param null $caption
     * @param array|null $th
     * @param array|null $tdRows
     * @return string
     */
    protected function outputHtmlTable($caption = null, array $th = null, array $tdRows = null)
    {
        $rstHtml = "<table width=100% align=center border=1 cellspacing=0 cellpadding=0>";

        if (!is_null($caption)) {
            $rstHtml .= "<caption>" . $caption . "</caption>";
        }

        if (!empty($th)) {
            $rstHtml .= "<tr>";
            foreach ($th as $h) {
                $rstHtml .= "<th>" . $h . "</th>";
            }
            $rstHtml .= "</tr>";
        }

        if (!empty($tdRows)) {
            foreach ($tdRows as $tdRow) {
                $rstHtml .= "<tr align=center>";
                foreach ($tdRow as $td) {
                    $rstHtml .= "<td>" . $td . "</td>";
                }
                $rstHtml .= "</tr>";
            }
        }

        $rstHtml .= "</table>";
        return $rstHtml;
    }

    public function getFullUrl()
    {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        return "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    }

    public function isFromWeixin()
    {
        return isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false;
    }
}
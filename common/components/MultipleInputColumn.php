<?php

namespace common\components;

use unclead\multipleinput\MultipleInputColumn as BaseMultipleInputColumn;

class MultipleInputColumn extends BaseMultipleInputColumn
{
    public function getElementName($index, $withPrefix = true)
    {
        if ($index === null) {
            $index = '{' . $this->renderer->getIndexPlaceholder() . '}';
        }

        $elementName = $this->isRendererHasOneColumn()
            ? '[' . $index . ']'
            : '[' . $index . '][' . $this->name . ']';

        if (!$withPrefix) {
            return $elementName;
        }

        $prefix = $this->getInputNamePrefix();
        if ($this->context->isEmbedded && strpos($prefix, $this->context->name) === false) {
            $prefix = $this->context->name;
        }

        return $prefix . $elementName . (empty($this->nameSuffix) ? '' : ('_' . $this->nameSuffix));
    }

    /**
     * @return bool
     */
    protected function isRendererHasOneColumn()
    {
        return count($this->renderer->columns) === 1;
    }
}
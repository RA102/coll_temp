<?php

namespace common\components;

use yii\base\Configurable;
use yii\base\ViewContextInterface;

class EmailRenderer implements Configurable, ViewContextInterface
{
    const LAYOUT = 'layouts/html';

    /** @var string */
    private $_viewPath;
    /** @var array */
    private $_view;

    /**
     * EmailComposer constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        if (!isset($config['view']) || !isset($config['viewPath'])) {
            throw new \InvalidArgumentException("View and view path must be specified");
        }

        $this->_view = $config['view'];
        $this->_viewPath = $config['viewPath'];
    }

    /**
     * @param string $view
     * @param array $params
     * @return mixed
     */
    public function render(string $view, $params = [])
    {
        $output = $this->getView()->render($view, $params, $this);

        return $this->getView()->render(self::LAYOUT, ['content' => $output], $this);
    }

    /**
     * @return object
     */
    public function getView()
    {
        if (!is_object($this->_view)) {
            $this->_view = \Yii::createObject($this->_view);
        }

        return $this->_view;
    }

    /**
     * @return string
     */
    public function getViewPath()
    {
        return \Yii::getAlias($this->_viewPath);
    }
}
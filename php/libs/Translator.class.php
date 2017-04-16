<?php

/**
 * 翻译基类
 */
abstract class Translator {
	/**
	 * 执行翻译
	 *
	 * @param string $text 待翻译字符串
	 * @param string $from 源语言
	 * @param string $to 目标语言
	 * @return mixed 翻译结果
	 */
	abstract public function doTranslate($text = '', $from = '', $to = '');
}
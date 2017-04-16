<?php

/**
 * 百度翻译
 */
require_once 'Translator.class.php';

class BaiduTranslator extends Translator {
	// 接口链接
	private $_apiURL = 'http://api.fanyi.baidu.com/api/trans/vip/translate';
	// APPID
	private $_appid = '****************';
	// 密钥
	private $_apiKey = '***********';

	public function doTranslate($text = '', $from = 'auto', $to = 'en') {
		// 检查输入有效性
		$text = trim($text);
		if (!isset($text{0})) {
			return '';
		}
		try {
			// 初始化CURL
			$curl = curl_init();
			// 随机生成盐
			$salt = date('YmdHis') . rand(100000, 999999);
			// 组装查询字段
			$query = array(
				'q'     => $text,
				'from'  => $from,
				'to'    => $to,
				'appid' => $this->_appid,
				'salt'  => $salt,
				'sign'  => $this->_generateSign($text, $salt),
			);
			curl_setopt_array($curl, array(
				CURLOPT_URL            => $this->_apiURL,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_POST           => true,
				CURLOPT_POSTFIELDS     => $query,
			));
			// 执行请求
			$response = curl_exec($curl);
			curl_close($curl);
		} catch (\Exception $e) {
			return '';
		}
		// 解析返回数据并返回翻译后值
		$jsonData = json_decode($response, true);
		// 检查是否出错
		if (isset($jsonData['error_code']) && $jsonData['error_code'] != '52000') {
			// 输出错误内容并停止程序
			$this->_showError($jsonData['error_code'], true);
		}
		return isset($jsonData['trans_result'][0]['dst']) ? $jsonData['trans_result'][0]['dst'] : '';
	}

	/**
	 * 生成签名
	 *
	 * @param string $text 待翻译字段
	 * @param string $salt 盐
	 * @return string 签名
	 */
	private function _generateSign($text = '', $salt = '') {
		return md5($this->_appid . $text . $salt . $this->_apiKey);
	}

	/**
	 * 显示错误并退出
	 *
	 * @param string $code 错误码
	 * @param bool $isExit 是否退出
	 */
	private function _showError($code, $isExit = false) {
		$errors = array(
			'52000' => '成功',
			'52001' => '请求超时',
			'52002' => '系统错误',
			'52003' => '未授权用户',
			'54000' => '必填参数为空',
			'58000' => '客户端IP非法',
			'54001' => '签名错误',
			'54003' => '访问频率受限',
			'58001' => '译文语言方向不支持',
			'54004' => '账户余额不足',
			'54005' => '长query请求频繁',
		);
		echo '百度翻译出错，错误码：', $code, ', 错误描述：', $errors[$code], PHP_EOL;
		if ($isExit) {
			exit();
		}
	}
}
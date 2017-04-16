<?php
/**
 * 针对
 * PHP 7.1.4 环境下测试通过
 */
require_once __DIR__ . '/libs/BaiduTranslator.php';
// 数据库
$dbEngine = 'mysql';
// 数据库IP
$dbHost = 'localhost';
// 数据库端口
$dbPort = '3306';
// 数据库仓库名称
$dbName = 'db_word_area';
// 数据库用户名
$dbUsername = 'root';
// 数据库口令
$dbPassword = 'root';
// 数据库编码
$dbCharset = 'utf8mb4';

// 省份表名
$tbProvince = 'province';
// 城市表名
$tbCity = 'city';
// 地区表名
$tbArea = 'area';

// 实例化翻译工具对象
$translator = new BaiduTranslator();
// 加载数据库链接对象
$pdo = new PDO("{$dbEngine}:host={$dbHost};port={$dbPort};dbname={$dbName}",
	$dbUsername, $dbPassword, array(
		PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES '{$dbCharset}'",
	));
//#region 省份名称在线翻译
if (!file_exists(__DIR__ . '/dist/provinceTran.json')) {
	echo '未检查到省份翻译文件，开始在线翻译获取。。。', PHP_EOL;
	$sql = "SELECT * FROM `{$tbProvince}`";
	$query = $pdo->query($sql);
	$provinceTran = array();
	foreach ($query as $row) {
		echo "正在翻译：" . $row['name'], PHP_EOL;
		$provinceTran[$row['code']] = array(
			'code'    => $row['code'],
			'en_name' => $translator->doTranslate($row['name']),
		);
	}
	echo "正在保存省份翻译结果到文件。。。。。", PHP_EOL;
	file_put_contents(__DIR__ . '/dist/provinceTran.json', json_encode($provinceTran));
	echo "正在保存省份翻译结果成功！", PHP_EOL;
}
//#endregion

//#region 城市名称在线翻译
if (!file_exists(__DIR__ . '/dist/cityTran.json')) {
	echo '未检查到城市翻译文件，开始在线翻译获取。。。', PHP_EOL;
	$sql = "SELECT * FROM `{$tbCity}`";
	$query = $pdo->query($sql);
	$cityTran = array();
	foreach ($query as $row) {
		echo "正在翻译：" . $row['name'], PHP_EOL;
		$cityTran[$row['code']] = array(
			'code'    => $row['code'],
			'en_name' => $translator->doTranslate($row['name']),
		);
	}
	echo "正在保存城市翻译结果到文件。。。。。", PHP_EOL;
	file_put_contents(__DIR__ . '/dist/cityTran.json', json_encode($cityTran));
	echo "正在保存城市翻译结果成功！", PHP_EOL;
}
//#endregion

//#region 地区名称在线翻译
if (!file_exists(__DIR__ . '/dist/areaTran.json')) {
	echo '未检查到城市翻译文件，开始在线翻译获取。。。', PHP_EOL;
	$sql = "SELECT * FROM `{$tbArea}`";
	$query = $pdo->query($sql);
	$areaTran = array();
	foreach ($query as $row) {
		echo "正在翻译：" . $row['name'], PHP_EOL;
		$areaTran[$row['code']] = array(
			'code'    => $row['code'],
			'en_name' => $translator->doTranslate($row['name']),
		);
	}
	echo "正在保存地区翻译结果到文件。。。。。", PHP_EOL;
	file_put_contents(__DIR__ . '/dist/areaTran.json', json_encode($areaTran));
	echo "正在保存地区翻译结果成功！", PHP_EOL;
}
//#endregion

// 将翻译结果保存到数据库
//#region 省份翻译数据写入数据库
// 从文件读取省份翻译数据
$provinceTran = json_decode(file_get_contents(__DIR__ . '/dist/provinceTran.json'), true);
// SQL 组装
$sql = "UPDATE `{$tbProvince}` set `en_name` = CASE `code` \n";
foreach ($provinceTran as $code => $value) {
	$sql .= "WHEN {$value['code']} THEN '{$value['en_name']}'\n";
}
$codes = implode(',', array_keys($provinceTran));
$sql .= "END \n WHERE `code` IN ({$codes});";
$pdo->exec($sql);
//#endregion

//#region 城市翻译数据写入数据库
// 从文件读取城市翻译数据
$cityTran = json_decode(file_get_contents(__DIR__ . '/dist/cityTran.json'), true);
// SQL 组装
$sql = "UPDATE `{$tbCity}` set `en_name` = CASE `code` \n";
foreach ($cityTran as $code => $value) {
	$enName = addcslashes($value['en_name'], '\'');
	$sql .= "WHEN {$value['code']} THEN '{$enName}'\n";
}
$codes = implode(',', array_keys($cityTran));
$sql .= "END \n WHERE `code` IN ({$codes});";
$pdo->exec($sql);
//#endregion

//#region 地区翻译数据写入数据库
// 从文件读取地区翻译数据
$areaTran = json_decode(file_get_contents(__DIR__ . '/dist/areaTran.json'), true);
// SQL 组装
$sql = "UPDATE `{$tbArea}` set `en_name` = CASE `code` \n";
foreach ($areaTran as $code => $value) {
	$enName = addcslashes($value['en_name'], '\'');
	$sql .= "WHEN {$value['code']} THEN '{$enName}'\n";
}
$codes = implode(',', array_keys($areaTran));
$sql .= "END \n WHERE `code` IN ({$codes});";
$pdo->exec($sql);
//#endregion
$pdo = null;

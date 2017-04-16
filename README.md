# worldArea
MySQL数据库脚本，包含世界各地区的地区编码以及中文名称。

## 简介

- 2016年2月12日 22:03:58

本脚本的数据部分内容从腾讯QQ安装目录下面的Localist.xml文件中提取并修改。
脚本执行之后会创建一个名为world_area的数据库，其中包含4张表格，分别是country（国家）、state（州、省）、city（城市）、region（地区）。

每一个国家、州（省）、城市、地区的编码（code）分别为3、6、9、12位。以地区编码为例，前3位表示国家编码，前6位表示州（省） 编码，前9位表示城市编码，上级区域编码表征信息以此类推。


- 2017年3月12日 22:54:33

新增从[Administrative-divisions-of-China项目](https://github.com/modood/Administrative-divisions-of-China)中提取的省市区SQL脚本，该脚本为最新的全国省市区数据，但是和以上的数据版本不兼容。


## 文件说明

### SQL文件备注

| 文件名                       | 备注                                       |
| ------------------------- | ---------------------------------------- |
| world_area.sql            | 世界范围的地区信息；                               |
| chinese_area_1.sql        | 从word_area.sql中提取出中国的地区信息；               |
| chinese_area_2.sql        | 将chinese_area_1.sql中的省份、城市、地区的行政规划ID去除，以自定义整型取代之； |
| chinese_area_2冗余版.sql     | chinese_area_2.sql中城市、地区表格包含上一级的ID和名称；   |
| chinese_area_2(ID整型化).sql | chinese_area_2.sql中将省份、城市、地区的行政规划的字符串ID转化为整型； |
| chinese_area(ID整型化,城市首字母).sql | chinese_area_2.sql中将省份、城市、地区的行政规划的字符串ID转化为整型，为城市表添加首字母字段； |
| Administrative-divisions-of-China.sql | 从[Administrative-divisions-of-China项目](https://github.com/modood/Administrative-divisions-of-China)中提取的省市区SQL脚本，未作冗余 |
| Administrative-divisions-of-China with English name.sql | 上一条SQL脚本的包含英文地名版本|

---

### JS文件备注

| 文件名                       | 备注                                       |
| ------------------------- | ---------------------------------------- |
| chinese_area.js           | chinese_area_2(ID整型化).sql对应的js版本，可以用来制作三级联动。 |
| citiesWithInitial.js           | chinese_area(ID整型化,城市首字母).sql中城市表格对应的js版本，可以用来完成城市按字母检索的功能；

## 地名英文翻译说明
利用PHP脚本调用百度翻译API完成，因为市机器翻译，可能存在翻译错误的情况，请见谅。

## 最后更新时间
2017年4月16日 19:35:56

## 版权说明
本项目遵循[MIT协议](http://www.opensource.org/licenses/MIT)。
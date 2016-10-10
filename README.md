# worldArea
##MySQL数据库脚本，包含世界各地区的地区编码以及中文名称。

本脚本的数据部分内容从腾讯QQ安装目录下面的Localist.xml文件中提取并修改。
脚本执行之后会创建一个名为world_area的数据库，其中包含4张表格，分别是country（国家）、state（州、省）、city（城市）、region（地区）。

每一个国家、州（省）、城市、地区的编码（code）分别为3、6、9、12位。以地区编码为例，前3位表示国家编码，前6位表示州（省） 编码，前9位表示城市编码，上级区域编码表征信息以此类推。

2016年2月12日 22:03:58

---

SQL文件备注

| 文件名                       | 备注                                       |
| ------------------------- | ---------------------------------------- |
| world_area.sql            | 世界范围的地区信息；                               |
| chinese_area_1.sql        | 从word_area.sql中提取出中国的地区信息；               |
| chinese_area_2.sql        | 将chinese_area_1.sql中的省份、城市、地区的行政规划ID去除，以自定义整型取代之； |
| chinese_area_2冗余版.sql     | chinese_area_2.sql中城市、地区表格包含上一级的ID和名称；   |
| chinese_area_2(ID整型化).sql | chinese_area_2.sql中将省份、城市、地区的行政规划的字符串ID转化为整型。 |
| chinese_area.js           | chinese_area_2(ID整型化).sql对应的js版本，可以用来制作三级联动 |

2016年10月10日 10:21:07
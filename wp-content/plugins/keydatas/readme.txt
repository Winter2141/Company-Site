=== 简数数据采集和发布平台 ===
Contributors: zhengdon
Tags:  文章采集,采集,简数,微信公众号,今日头条,数据采集
Donate link: http://www.keydatas.com
Author URI: http://www.keydatas.com
Plugin URI: http://www.keydatas.com/wordpress-plugin
Stable tag: 2.3.19
Requires at least: 4.1
Tested up to: 5.2.4
Requires PHP: 5.2.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

简数是一个通用简单在线的网页数据采集和发布平台。支持:定时采集自动发布;强大SEO工具和翻译;微信公众号和今日头条采集;图片可存储到阿里云OSS,七牛,腾讯云。


== Description ==

简数(<a href="http://www.keydatas.com" target="_blank">keydatas.com</a>)是一个通用、简单、智能、在线的网页数据采集和发布平台，主要功能特性：<br>
1.采集不需安装任何客户端或插件，不用研究网页源代码，在线选取、点击，保存，就可以实现采集；<br>
2.提供强大的<a href="http://doc.keydatas.com/task/seo.html" target="_blank" >SEO工具</a>，包括：<a href="http://doc.keydatas.com/task/seo/seo-tool/insert-dynamic-para.html" target="_blank" >正文插入动态段落(强烈推荐)</a>、正文插入段落及标题自动关键词、标题插入关键词、自动内链、同义词替换、简繁体转换、翻译等；<br>
3.支持微信公众号文章采集(包括公众号历史文章)和今日头条采集，仅需输入微信公众号名称或ID或者关键词即可采集；支持淘宝联盟商品采集；<br>
4.智能识别数据和规则，包括：列表页、翻页和详情页（标题、正文、作者、发布时间等）；<br>
5.定时采集更新，自动发布；定时发布和站群发布；<br>
6.灵活强大的数据二次加工处理工具；<br>
7.图片支持下载到（阿里云OSS、七牛对象存储、腾讯云COS、又拍云），突破防盗链；<br>
8.多节点分布式采集，免费IP代理等机制；WPJAM-Basic。<br>
9.相比火车头(locoy)、八爪鱼(bazhuayu)、神剑手后羿(shenjianshou)，简数采集更加简单易用，功能同样强大，且没有繁杂的流程。功能也覆盖wpspider、WP-AutoPost(WP-AutoBlog)、WP-Jpost等采集插件。<br>
10.书签一键采集发布:随时随地，看到好的文章，点击浏览器书签即可把第三方网页内容采集并发布到您的网站！<br>
11.we also include caiji,seo,mip,keyword,description,jianshu,weixin,wechat,robot,spider,jinritoutiao,taobaoke,aliyun,qiniu,<br>tengxunyun,baidu,huochetou,houyicaiji,shenjian,CSDN,cnblogs,zhihu,jianshu,wenzhang,gongzhonghao<br>
12.SEO Plugin,huochetou,google XML sitemap,WP Baidu Map,baiduxzh,Sitemap,baidu-submit-link,AutoTags,Github<br>
autospider,fanyi,Translate,LightSNS,collect.
13.wordpress插件推荐：百度熊掌号,WordPress HTTPS (SSL),wp encrypt,really simple ssl,wp-super-cache,WP Rocket,All-in-One SEO Pack,login LockDown,Comments Link Redirect,Add Post URL,BackWPup,DX-auto-publish,Link Manager,No Category Parents,Platinum SEO Pack,WP Keyword Link,Yet Another Related Posts Plugin,Fix image width,Role Manager,Search & Replace,WordPress Database Backup,WP-PostViews,WP PHP widget,Baidu Sitemap Generator,DB Cache Reloaded Fix + Hyper Cache,SEO Friendly Images,BackWPup,Simple URLs,Redirection.

== Installation ==
安装：
在WordPress插件后台搜索 keydatas 或 “简数” 或 “数据采集” 安装启用即可
更多详情请访问<a href="http://www.keydatas.com" target="_blank">简数官网</a>

== Frequently Asked Questions ==

== Screenshots ==

1. 采集后的结果数据。
2. 详情内容提取器，通过点选提取想要的字段内容。
3. 数据二次处理：替换，填充，截取，删除、同义词替换，中间插入其它记录内容等批量操作。
4. 发布到wordpress配置映射，通过鼠标选择即可完成
5. 数据发布情况展示，可以直接查看发布后的数据

== Changelog ==
= 2.3.4 =
* 修改使用随机用户在一些环境异常问题。
= 2.3.3 =
* 加入支持文章别名自定义。
= 2.3.2 =
* 分类支持提交分类id或分类名称。
= 2.3.0 =
* 增加支持LightSNS主题发布。
= 2.2.4 =
* 解决标题特殊字符无法去重问题
= 2.2.1 =
* 去掉时区设置
= 2.2.0 =
* 当图片下载使用“存储到简数”，在发布时，可以同时发送图片了（针对wp默认上传目录的），接收后不需再使用ftp回传图片。
= 2.1.7 =
* 添加文档链接以及功能特性说明。
= 2.1.6 =
* 当图片下载使用暂存简数，在发布时，不再需要先ftp回传图片，也可以生成特色图片。
= 2.1.5 =
* 标题判断优化
= 2.1.4 =
* 解决postMeat update以及用户名判断问题
= 2.1.2 =
* 解决多分类目录问题
= 2.1.1 =
* 加入文章类型自定义
= 2.0.11 =
* 加入时间定义
= 2.0.9 =
* 解决图片链接已双斜杠开头问题
= 2.0.8 =
* 解决标签问题
= 2.0.7 =
* 解决标题重复判断问题
= 2.0.6 =
* 支持把发布目标的扩展参数保存到wp_postmeta表中
= 2.0.5 =
* 支持发布到淘宝客WordPress插件
== Upgrade Notice ==


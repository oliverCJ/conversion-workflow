alfred 2 进制转换插件
=========================
简介
-------------------------
支持自动判断输入字符并转换成其他进制，目前支持16进制，10进制，8进制，2进制之间的任意转换
> 命令 **cov**

输入格式：
-------------------------
16进制：以0x开头
```16
cov 0xFFFF
```
8进制：以0c开头
```8
cov 0x7777
```
2进制：以b开头
```2
cov b1111
```
10进制：无前缀，直接输入数字
```10
cov 9999
```
> 回车即复制到剪贴板


例子
--------------------------
16进制转换为其他进制
```ex
cov 0xFFFF
```
结果：
2进制：b1111111111111111
8进制：0c177777
10进制：65535
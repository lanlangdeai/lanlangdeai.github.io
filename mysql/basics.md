# 基础篇







## 常用命令



- 查看MySQL默认加载地my.cnf文件

```
1.若启动时指定加载的配置文件
ps aux|grep mysql|grep 'my.cnf'
如果命令没有输出， 则表示没有设置使用指定目录的my.cnf

2.查看MySQL默认读取my.cnf
mysql --help|grep 'my.cnf'
>>> /etc/my.cnf /etc/mysql/my.cnf /usr/local/mysql/etc/my.cnf ~/.my.cnf
这些就是MySQL默认搜索的配置目录，顺序排前的优先
```



- 启动， 停止，重启操作

```
Fedora Core/CentOS
1.启动
/etc/init.d/mysqld start
2.停止
/etc/init.d/mysqld stop
3.重启
/etc/init.d/mysqld restart

Debian/Ubuntu
1.启动
/etc/init.d/mysql start
2.停止
/etc/init.d/mysql stop
3.重启
/etc/init.d/mysql restart
```


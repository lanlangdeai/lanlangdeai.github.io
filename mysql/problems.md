# 常见问题





1. ### MySQL数据导入报错：Got a packet bigger than‘max_allowed_packet’bytes的问题

解决： 修改my.cnf配置， 然后重启MySQL

```
添加配置项：
max_allower_package=512M
```


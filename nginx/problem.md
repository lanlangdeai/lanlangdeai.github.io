# Nginx相关问题





1.访问日志中有大量的head请求，处理方式

```nginx
server{
	if ($request_method ~ ^(HEAD)$ ) {
		return 200 "All OK";
	}
}
```


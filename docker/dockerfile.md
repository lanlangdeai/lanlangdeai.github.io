Dockerfile文件

镜像构建命令说明文件



常用命令：

- FROM

 一般除了注释会放到第一行， 表示该镜像的基础镜像

- MAINTAINER

标识维护人的信息， 可以后面添加维护者的名称

- RUN

执行一条命令

- COPY

进行文件的拷贝

- ENTRYPOINT

标识命令文件的入点

- EXPOSE

标识暴露的端口











Demo：

1.构建一个nginx服务镜像

```
FROM ubuntu
MAINTAINER x-wolf
RUN sed -i 's/archive.ubuntu.com/mirrors.ustc.edu.cn/g'  /etc/apt/sources.list
RUN apt-get update
RUN apt-get install -y nginx
COPY index.html  /var/www/html
ENTRYPOINT ["/usr/bin/nginx", "-g", "daemon off;"]
EXPOSE 80
```
































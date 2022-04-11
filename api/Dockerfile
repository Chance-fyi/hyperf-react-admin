FROM php:8.0.0-cli

RUN set -x \
    # 切换源
    && sed -i 's/deb.debian.org/mirrors.aliyun.com/g' /etc/apt/sources.list \
    # 更新依赖
    && apt-get update \
    && apt-get install -y zlib1g-dev  \
                          zip \
    # 创建`/usr/src/php/ext`目录
    && docker-php-source extract \
    # 下载扩展 printf "" | 是为了跳过扩展安装过程中弹出选择的yes no
    && printf "" | pecl install swoole-4.6.7 \
                                redis-5.3.6 \
    # 安装扩展
    && docker-php-ext-install pdo_mysql \
                              pcntl \
    # 开启扩展
    && docker-php-ext-enable swoole \
                             redis \
    && echo "swoole.use_shortname=off" >> /usr/local/etc/php/conf.d/docker-php-ext-swoole.ini \
    # 安装composer
    && curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/bin/composer && chmod +x /usr/bin/composer \
    # 删除`/usr/src/php/ext`目录
    && docker-php-source delete \
    && rm -rf /tmp/* \
    # 清理apt缓存文件
    && apt-get purge
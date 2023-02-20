FROM php:7-apache

RUN apt-get update
RUN apt-get install -y --no-install-recommends \
      git \
      zip \
      mariadb-client \
      default-libmysqlclient-dev \
      libbz2-dev \
      libmemcached-dev \
      libsasl2-dev \
      libfreetype6-dev \
      libicu-dev \
      libjpeg-dev \
      libmemcachedutil2 \
      libpng-dev \
      libxml2-dev \
      ffmpeg \
      libimage-exiftool-perl \
      curl \
      python3 \
      python3-pip \
      libzip-dev \
      libonig-dev \
      wget && \
    docker-php-ext-configure gd --with-freetype=/usr/include --with-jpeg=/usr/include && \
    docker-php-ext-install -j$(nproc) \
      bcmath \
      bz2 \
      calendar \
      exif \
      gd \
      gettext \
      iconv \
      intl \
      mbstring \
      mysqli \
      opcache \
      pdo_mysql \
      zip && \
    rm -rf \
      /tmp/* \
      /var/lib/apt/lists/* \
      /var/tmp/* \
      /root/.cache && \
    a2enmod rewrite expires headers ssl

COPY . /app

COPY deploy/docker-entrypoint /usr/local/bin/docker-entrypoint
RUN chmod +x /usr/local/bin/docker-entrypoint

ENTRYPOINT ["/usr/local/bin/docker-entrypoint"]
HEALTHCHECK --interval=60s --timeout=55s --start-period=1s CMD curl --fail http://localhost/ || exit 1  
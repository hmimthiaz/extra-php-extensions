ARG CPU_PREFIX
ARG PHP_VERSION
ARG BREF_VERSION
FROM bref/${CPU_PREFIX}build-php-$PHP_VERSION:$BREF_VERSION AS ext

# Install required libraries
ENV LD_LIBRARY_PATH=/usr/lib:/usr/lib64:$LD_LIBRARY_PATH

RUN yum -y install amazon-linux-extras

RUN amazon-linux-extras install -y epel

# Install image tools
RUN yum -y install  \
    jpegoptim \
    optipng \
    pngquant \
    gifsicle \
    libwebp-tools

# Copy dependencies
RUN php /bref/lib-copy/copy-dependencies.php /usr/bin/jpegoptim /tmp/extension-libs
RUN php /bref/lib-copy/copy-dependencies.php /usr/bin/optipng /tmp/extension-libs
RUN php /bref/lib-copy/copy-dependencies.php /usr/bin/pngquant /tmp/extension-libs
RUN php /bref/lib-copy/copy-dependencies.php /usr/bin/gifsicle /tmp/extension-libs
RUN php /bref/lib-copy/copy-dependencies.php /usr/bin/cwebp /tmp/extension-libs


# Build the final image with just the files we need
FROM scratch

# Copy things we installed to the final image
COPY --from=ext /usr/bin/jpegoptim /opt/bin/jpegoptim
COPY --from=ext /usr/bin/optipng /opt/bin/optipng
COPY --from=ext /usr/bin/pngquant /opt/bin/pngquant
COPY --from=ext /usr/bin/gifsicle /opt/bin/gifsicle
COPY --from=ext /usr/bin/cwebp /opt/bin/cwebp
COPY --from=ext /tmp/extension-libs /opt/lib

# X86 fails for these library
COPY --from=ext /usr/lib64/liblcms2.so.2 /opt/lib
COPY --from=ext /usr/lib64/libgomp.so.1 /opt/lib

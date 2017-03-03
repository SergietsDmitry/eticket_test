### Nginx settings ###

	server {
		listen 80;
		server_name e_tickets.dev *.e_tickets.dev;
		root "C:/laragon/www/e_tickets/public/";

		index index.html index.htm index.php;

		location / {
			try_files $uri $uri/ /index.php$is_args$args;
		}

		location ~ \.php$ {
			include snippets/fastcgi-php.conf;
			fastcgi_pass php_upstream;		
			#fastcgi_pass unix:/run/php/php7.0-fpm.sock;
		}


		charset utf-8;

		location = /favicon.ico { access_log off; log_not_found off; }
		location = /robots.txt  { access_log off; log_not_found off; }
		location ~ /\.ht {
			deny all;
		}
	}
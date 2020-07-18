server {
        listen 80;
	listen [::]:80;

	access_log /home/radik/projects/logs/authsys-access.log;
	error_log /home/radik/projects/logs/authsys-error.log;

        root /home/radik/projects/authsys/public;
        index index.php index.html index.htm index.nginx-debian.html;
        server_name authsys.local;

        location / {
                #try_files $uri $uri/ =404;
		try_files $uri $uri/ @missing;
        }

        location ~ \.php$ {
                include snippets/fastcgi-php.conf;
                fastcgi_pass unix:/var/run/php/php7.2-fpm.sock;
        }

        location ~ /\.ht {
                deny all;
        }

	location @missing {
        	rewrite ^ /index.php last;
		#rewrite ^/(.*)$ /index.php?q=$1&$args;
    	}
}

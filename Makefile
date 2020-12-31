prod-deploy: prod-update prod-set stop upd

prod-update:
	git pull origin master

prod-set:
	ln -sfv docker-compose.override.prod.yaml.dist docker-compose.override.yaml

dev-set:
	ln -sfv docker-compose.override.dev.yaml.dist docker-compose.override.yaml

up:
	docker-compose up

upd:
	docker-compose up -d

stop:
	docker-compose stop

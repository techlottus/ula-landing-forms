FROM mattrayner/lamp:latest

# Your custom commands
VOLUME [ "${PWD}/app:app" ]
EXPOSE 80
ADD app/ /app

CMD ["/run.sh"]
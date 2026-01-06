FROM node:alpine3.23

WORKDIR /app

RUN apk add --no-cache \
    git \
    make \
    && rm -rf /var/cache/apk/*

#use cache
COPY ./node/package.json ./node/package-lock.json ./
RUN npm install

COPY ./node .
CMD ["npm", "run", "dev"]

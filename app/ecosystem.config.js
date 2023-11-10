const env = require('dotenv').config().parsed

module.exports = ({
  apps: [
    {
      name: env.NAME1,
      script: env.SCRIPT,
      args: env.ARGS,
      env: {
        NODE_ENV: env.NAME1,
        GRANT_TYPE: env.GRANT_TYPE,
        CLIENT_ID: env.CLIENT_ID,
        CLIENT_SECRET: env.CLIENT_SECRET,
        USERNAME: env.USERNAME,
        PASSWORD: env.PASSWORD,
      }
    }
  ]
});
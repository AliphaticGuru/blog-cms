-- This script runs when the Postgres container is first created

-- Ensure DB exists (though docker-compose already sets POSTGRES_DB)
CREATE DATABASE blog_cms;

-- Create user (already handled by POSTGRES_USER/PASSWORD env, but for clarity)
CREATE USER laravel WITH ENCRYPTED PASSWORD 'secret';

-- Give privileges
GRANT ALL PRIVILEGES ON DATABASE blog_cms TO laravel;
-- Note: In a production environment, avoid hardcoding passwords and use secure methods to manage credentials.
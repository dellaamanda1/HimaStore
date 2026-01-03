pipeline {
  agent any

  environment {
    COMPOSE = "docker compose"
    // ganti port host DB biar ga tabrakan (3307 kamu sudah kepakai)
    DB_HOST_PORT = "3310"
  }

  stages {

    stage('Checkout') {
      steps {
        checkout scm
      }
    }

    stage('Pre-clean (stop old containers)') {
      steps {
        // selalu bersihin project compose ini dulu
        bat '''
        %COMPOSE% down -v --remove-orphans
        '''
      }
    }

    stage('Docker Build') {
      steps {
        bat '''
        %COMPOSE% build
        '''
      }
    }

    stage('Start Containers') {
      steps {
        // override port db host biar pasti beda setiap pipeline
        bat '''
        set DB_HOST_PORT=%DB_HOST_PORT%
        %COMPOSE% up -d
        '''
      }
    }

    stage('Wait DB Ready') {
      steps {
        // tunggu mysql siap
        bat '''
        for /l %%i in (1,1,40) do (
          %COMPOSE% exec -T db mysqladmin ping -proot --silent && exit /b 0
          echo waiting mysql... %%i
          timeout /t 2 >nul
        )
        echo MySQL not ready
        exit /b 1
        '''
      }
    }

    stage('Laravel Setup') {
      steps {
        // pastikan dependencies ada, lalu setup laravel
        bat '''
        %COMPOSE% exec -T app composer install --no-interaction --prefer-dist
        %COMPOSE% exec -T app php artisan key:generate
        %COMPOSE% exec -T app php artisan migrate --force
        '''
      }
    }

    stage('Smoke Test') {
      steps {
        bat '''
        %COMPOSE% exec -T app php artisan route:list
        '''
      }
    }
  }

  post {
    always {
      bat '''
      %COMPOSE% ps
      %COMPOSE% logs --no-color --tail=200
      '''
    }

    cleanup {
      bat '''
      %COMPOSE% down -v --remove-orphans
      '''
    }
  }
}
pipeline {
  agent any

  environment {
    COMPOSE = "docker compose"
  }

  stages {

    stage('Checkout') {
      steps {
        checkout scm
      }
    }

    stage('Prepare Env') {
      steps {
        bat '''
        echo === Prepare .env ===
        if not exist .env (
          copy .env.example .env
          echo .env created from .env.example
        ) else (
          echo .env already exists
        )
        '''
      }
    }

    stage('Pre-clean (stop old containers)') {
      steps {
        bat '''
        echo === Pre-clean ===
        %COMPOSE% down -v || exit /b 0
        '''
      }
    }

    stage('Docker Build') {
      steps {
        bat '''
        echo === Docker Build ===
        %COMPOSE% build
        '''
      }
    }

    stage('Start Containers') {
      steps {
        bat '''
        echo === Start Containers ===
        %COMPOSE% up -d
        %COMPOSE% ps
        '''
      }
    }

    stage('Wait DB Ready') {
      steps {
        bat '''
        echo === Wait DB Ready ===

        docker compose exec -T db mysqladmin ping -uroot -proot --silent
        if %ERRORLEVEL%==0 (
          echo MySQL ready
          exit /b 0
        )

        echo Waiting 5 seconds...
        ping 127.0.0.1 -n 6 >nul

        docker compose exec -T db mysqladmin ping -uroot -proot --silent
        if %ERRORLEVEL%==0 (
          echo MySQL ready
          exit /b 0
        )

        echo Waiting 5 seconds...
        ping 127.0.0.1 -n 6 >nul

        docker compose exec -T db mysqladmin ping -uroot -proot --silent
        if %ERRORLEVEL%==0 (
          echo MySQL ready
          exit /b 0
        )

        echo ERROR: MySQL not ready after retries
        %COMPOSE% logs db
        exit /b 1
        '''
      }
    }

    stage('Laravel Setup') {
      steps {
        bat '''
        echo === Laravel Setup ===

        echo (1) Ensure APP_KEY exists...
        docker compose exec -T app php -r "exit((strpos(file_get_contents('.env'), 'APP_KEY=')!==false && trim(explode('=', preg_grep('/^APP_KEY=/', file('.env'))[0])[1])!=='') ? 0 : 1);"
        if NOT %ERRORLEVEL%==0 (
          echo APP_KEY empty, generating...
          %COMPOSE% exec -T app php artisan key:generate
        ) else (
          echo APP_KEY already set
        )

        echo (2) Migrate...
        %COMPOSE% exec -T app php artisan migrate --force

        echo (3) Cache clear (optional)...
        %COMPOSE% exec -T app php artisan config:clear
        %COMPOSE% exec -T app php artisan cache:clear
        '''
      }
    }

    stage('Smoke Test') {
      steps {
        bat '''
        echo === Smoke Test ===
        %COMPOSE% exec -T app php artisan route:list
        '''
      }
    }
  }

  post {
    always {
      bat '''
      echo === Final docker ps ===
      %COMPOSE% ps
      '''
    }
    cleanup {
      bat '''
      echo === Cleanup ===
      %COMPOSE% down -v
      '''
    }
  }
}
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
                if not exist .env (
                    copy .env.example .env
                )
                '''
            }
        }

        stage('Docker Build') {
            steps {
                bat '%COMPOSE% build'
            }
        }

        stage('Start Containers') {
            steps {
                bat '%COMPOSE% up -d'
            }
        }

        stage('Wait DB Ready') {
            steps {
                bat '''
                for /l %%i in (1,1,20) do (
                    %COMPOSE% exec -T db mysqladmin ping -h db -proot && exit /b 0
                    echo Waiting MySQL... %%i
                    timeout /t 3 >nul
                )
                exit /b 1
                '''
            }
        }

        stage('Laravel Setup') {
            steps {
                bat '%COMPOSE% exec -T app php artisan key:generate'
                bat '%COMPOSE% exec -T app php artisan migrate --force'
            }
        }

        stage('Smoke Test') {
            steps {
                bat '%COMPOSE% exec -T app php artisan route:list'
            }
        }
    }

    post {
        always {
            bat '%COMPOSE% ps'
        }
        cleanup {
            bat '%COMPOSE% down'
        }
    }
}
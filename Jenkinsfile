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
        // nunggu mysql siap biar migrate gak gagal
        bat '''
        for /l %%i in (1,1,20) do (
        %COMPOSE% exec -T db mysqladmin ping -h 127.0.0.1 -proot && exit /b 0
        echo waiting mysql... %%i
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
        // bukti laravel hidup + route kebaca
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
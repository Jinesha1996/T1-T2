pipeline {
    agent any
    environment {
        DOCKER_USERNAME = credentials('DOCKER_USERNAME')
        DOCKER_PASSWORD = credentials('DOCKER_PASSWORD')
        KUBECONFIG_CONTENT = credentials('KUBECONFIG')
        SONAR_HOST_URL = credentials('SONAR_HOST_URL')
        SONAR_TOKEN = credentials('SONAR_TOKEN')
    }
    stages {
        stage('Checkout') {
            steps {
                checkout scm
            }
        }
        stage('SonarQube Analysis') {
            steps {
                withSonarQubeEnv('SonarQubeServer') {
                    sh '''
                    sonar-scanner \
                      -Dsonar.projectKey=my-php-app \
                      -Dsonar.sources=. \
                      -Dsonar.host.url=${SONAR_HOST_URL} \
                      -Dsonar.login=${SONAR_TOKEN}
                    '''
                }
            }
        }
        stage('Build Docker Image') {
            steps {
                script {
                    withEnv(['DOCKER_CONFIG=/home/jenkins/.docker']) {
                        sh 'mkdir -p /home/jenkins/.docker'
                        writeFile file: '/home/jenkins/.docker/config.json', text: '{"auths": {"https://index.docker.io/v1/": {"auth": "' + "${DOCKER_PASSWORD}" + '"}}}'
                        def imageName = "my-dockerhub-username/colorful-blog"
                        docker.build(imageName, '.').push()
                    }
                }
            }
        }
        stage('Deploy to Kubernetes') {
            steps {
                script {
                    writeFile file: 'kubeconfig', text: "${KUBECONFIG_CONTENT}"
                    withEnv(['KUBECONFIG=kubeconfig']) {
                        sh 'kubectl apply -f k8s/deployment.yaml'
                        sh 'kubectl apply -f k8s/service.yaml'
                    }
                }
            }
        }
    }
}

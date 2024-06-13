pipeline {
    agent any
    environment {
        DOCKER_CREDENTIALS_ID = 'Docker Credentials'
        KUBECONFIG_CREDENTIALS_ID = 'kube-config-credentials'
        SONAR_CREDENTIALS_ID = 'Sonarqube Credentials'
    }
    stages {
        stage('Checkout') {
            steps {
                checkout scm
            }
        }
        stage('SonarQube Analysis') {
            steps {
                withCredentials([usernamePassword(credentialsId: SONAR_CREDENTIALS_ID, usernameVariable: 'SONAR_HOST_URL', passwordVariable: 'SONAR_TOKEN')]) {
                    withSonarQubeEnv('SonarQubeServer') {
                        sh '''
                        sonar-scanner \
                          -Dsonar.projectKey=my-php-app \
                          -Dsonar.sources=. \
                          -Dsonar.host.url=$SONAR_HOST_URL \
                          -Dsonar.login=$SONAR_TOKEN
                        '''
                    }
                }
            }
        }
        stage('Build Docker Image') {
            steps {
                withCredentials([usernamePassword(credentialsId: DOCKER_CREDENTIALS_ID, usernameVariable: 'DOCKER_USERNAME', passwordVariable: 'DOCKER_PASSWORD')]) {
                    script {
                        withEnv(['DOCKER_CONFIG=/home/jenkins/.docker']) {
                            sh 'mkdir -p /home/jenkins/.docker'
                            writeFile file: '/home/jenkins/.docker/config.json', text: """
                            {
                                "auths": {
                                    "https://index.docker.io/v1/": {
                                        "auth": "${DOCKER_USERNAME}:${DOCKER_PASSWORD}"
                                    }
                                }
                            }
                            """
                            def imageName = "my-dockerhub-username/colorful-blog"
                            docker.build(imageName, '.').push()
                        }
                    }
                }
            }
        }
        stage('Deploy to Kubernetes') {
            steps {
                withCredentials([file(credentialsId: KUBECONFIG_CREDENTIALS_ID, variable: 'KUBECONFIG_FILE')]) {
                    script {
                        sh 'cp $KUBECONFIG_FILE kubeconfig'
                        withEnv(['KUBECONFIG=kubeconfig']) {
                            sh 'kubectl apply -f k8s/deployment.yaml'
                            sh 'kubectl apply -f k8s/service.yaml'
                        }
                    }
                }
            }
        }
    }
}

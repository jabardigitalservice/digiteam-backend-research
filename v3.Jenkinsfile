pipeline {
  agent any
  environment {
      REGISTRY_URL = "${env.REGISTRY_URL}"
      REGISTRY_USERNAME = "${env.DIGITEAM_REGISTRY_USERNAME}"
      REGISTRY_PASSWORD = "${env.DIGITEAM_REGISTRY_PASSWORD}"
      IMAGE_NAME = "${env.DIGITEAM_RESEARCH_IMAGE_NAME}"
  }
  options {
    timeout(time: 1, unit: 'HOURS')
  }
  stages {
    stage('Docker Build') {
      steps{
        dir ('sd-without-library') {
          sh 'docker build -t $IMAGE_NAME-v3:$BUILD_NUMBER -f docker/Dockerfile .'
        }
      }
    }
    stage('Docker Push') {
      steps{
        sh 'docker login -u $REGISTRY_USERNAME -p $REGISTRY_PASSWORD $REGISTRY_URL'
        sh 'docker push $IMAGE_NAME-v3:$BUILD_NUMBER'
      }
    }
  }
} 
pipeline {
  agent any

  stages {
    stage('Pull Latest Code') {
      steps {
        echo 'Fetching from GitHub (already configured via SCM plugin)'
        // No need to manually pull, Jenkins SCM is configured
      }
    }

    stage('Run Ansible Playbook') {
      steps {
        echo 'Running Ansible to install NGINX + PHP + Deploy HTML/PHP'

        sh '''
          ansible-playbook -i inventory.ini install_webapp.yaml
        '''
      }
    }
  }

  post {
    success {
      echo '✅ Web server deployed successfully.'
    }
    failure {
      echo '❌ Deployment failed. Please check the logs.'
    }
  }
}

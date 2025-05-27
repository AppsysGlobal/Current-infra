pipeline {
  agent any

  stages {
    stage('Checkout from GitHub') {
      steps {
        // GitHub SCM already configured in Jenkins job UI
        echo 'Checked out source from GitHub'
      }
    }

    stage('Run Ansible Playbook') {
      steps {
        echo 'Running Ansible to install NGINX and deploy index.html'
        sh '''
          ansible-playbook -i hosts install_nginx.yaml
        '''
      }
    }
  }
}

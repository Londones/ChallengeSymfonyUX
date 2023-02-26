packer {
  required_plugins {
    amazon = {
      version = "= 1.1.1"
      source  = "github.com/hashicorp/amazon"
    }
  }
}

locals {
  ami_name      = "challenge-stack-ami-${formatdate("YYYYMMDDhhmmss", timestamp())}"
  instance_type = "t2.micro"
  ami_region    = "eu-west-3"
  region        = "eu-west-3"
}

source "amazon-ebs" "aws_custom_debian_ami" {
  ami_name      = local.ami_name
  ami_regions   = [local.ami_region]
  instance_type = local.instance_type
  region        = local.region
  ssh_username  = "admin"

  source_ami_filter {
    filters = {
      name = "debian-11-amd64-*"
    }
    most_recent = true
    owners      = ["136693071363"]
  }

  tags = {
    Name       = local.ami_name
    created_by = "packer"
  }
}

build {
  sources = ["source.amazon-ebs.aws_custom_debian_ami"]
  name    = "aws-custom_debian-ami-build"

  provisioner "ansible" {
    ansible_env_vars       = ["ANSIBLE_LOCAL_TEMP=$HOME/.ansible/tmp", "ANSIBLE_REMOTE_TEMP=$HOME/.ansible/tmp"]
    ansible_ssh_extra_args = ["-oHostKeyAlgorithms=+ssh-rsa -oPubkeyAcceptedKeyTypes=+ssh-rsa"]
    extra_arguments        = ["--scp-extra-args", "'-O'"]
    playbook_file          = "./playbook.yml"
  }
}

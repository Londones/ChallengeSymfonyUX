locals {
  aws_region = "eu-west-3"
}

provider "aws" {
  region  = local.aws_region

  default_tags {
    tags = {
      created_by = "terraform"
    }
  }
}

resource "aws_vpc" "vpc" {
  cidr_block = var.vpc_cidr_block

  tags = {
    Name = "${var.vpc_name}"
  }
}

resource "aws_subnet" "public_subnet" {
  vpc_id                  = aws_vpc.vpc.id
  cidr_block              = var.public_subnet_cidr_block
  availability_zone       = var.subnet_az

  tags = {
    Name = "${var.vpc_name}-public-subnet"
  }
}

resource "aws_default_network_acl" "default_nacl" {
  default_network_acl_id = aws_vpc.vpc.default_network_acl_id

  ingress {
    protocol   = -1
    rule_no    = 100
    action     = "allow"
    cidr_block = "0.0.0.0/0"
    from_port  = 0
    to_port    = 0
  }

  egress {
    protocol   = -1
    rule_no    = 100
    action     = "allow"
    cidr_block = "0.0.0.0/0"
    from_port  = 0
    to_port    = 0
  }

  tags = {
    Name = "challenge-stack-nacl"
  }
}

resource "aws_internet_gateway" "vpc_ig" {
  vpc_id = aws_vpc.vpc.id

  tags = {
    Name = "${var.vpc_name}-internet-gateway"
  }
}

resource "aws_route_table" "vpc_public_route_table" {
  vpc_id = aws_vpc.vpc.id

  tags = {
    Name = "${var.vpc_name}-public-route-table"
  }
}

resource "aws_route" "public_route" {
  route_table_id         = aws_route_table.vpc_public_route_table.id
  destination_cidr_block = "0.0.0.0/0"
  gateway_id             = aws_internet_gateway.vpc_ig.id
}

resource "aws_main_route_table_association" "main_route_association" {
  vpc_id         = aws_vpc.vpc.id
  route_table_id = aws_route_table.vpc_public_route_table.id
}

resource "aws_security_group" "main_sg" {
  name   = "${var.vpc_name}_main_sg"
  vpc_id = aws_vpc.vpc.id

  ingress {
    from_port   = 22
    to_port     = 22
    protocol    = "TCP"
    cidr_blocks = ["0.0.0.0/0"]
  }

  ingress {
    from_port   = 80
    to_port     = 80
    protocol    = "TCP"
    cidr_blocks = ["0.0.0.0/0"]
  }

  ingress {
    from_port   = 443
    to_port     = 443
    protocol    = "TCP"
    cidr_blocks = ["0.0.0.0/0"]
  }

  egress {
    from_port   = 0
    to_port     = 0
    protocol    = -1
    cidr_blocks = ["0.0.0.0/0"]
  }
}

resource "tls_private_key" "ec2_key_pair" {
  algorithm = "RSA"
  rsa_bits  = 4096
}

resource "aws_key_pair" "main_key_pair" {
  key_name   = "challenge_stack_ec2_key_pair"
  public_key = tls_private_key.ec2_key_pair.public_key_openssh

  provisioner "local-exec" {
    command = "echo '${tls_private_key.ec2_key_pair.private_key_pem}' >> ./challenge-stack-key.pem"
  }
}

resource "aws_network_interface" "network_interface" {
  subnet_id       = aws_subnet.public_subnet.id
  private_ips     = [var.instance_private_ip]
  security_groups = [aws_security_group.main_sg.id]
}

resource "aws_instance" "ec2_instance" {
  ami           = data.aws_ami.custom_ami.id
  instance_type = var.instance_type
  key_name      = aws_key_pair.main_key_pair.key_name

  network_interface {
    network_interface_id = aws_network_interface.network_interface.id
    device_index         = 0
  }

  tags = {
    Name = "challenge-stack-instance"
  }
}

resource "aws_eip" "ec2_eip" {
  instance = aws_instance.ec2_instance.id
}

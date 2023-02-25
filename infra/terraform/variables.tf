variable "vpc_name" {
  type    = string
  default = "challenge-stack-vpc"
}

variable "instance_type" {
  type    = string
  default = "t2.micro"
}

variable "vpc_cidr_block" {
  type    = string
  default = "10.0.0.0/24"
}

variable "public_subnet_cidr_block" {
  type    = string
  default = "10.0.0.0/24"
}

variable "instance_private_ip" {
  type    = string
  default = "10.0.0.69"
}

variable "subnet_az" {
  type    = string
  default = "eu-west-3a"
}

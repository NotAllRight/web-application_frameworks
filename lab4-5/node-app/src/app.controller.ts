import { Controller, Get } from '@nestjs/common';
import { AppService } from './app.service';
import { Roles, Unprotected } from 'nest-keycloak-connect';
import { ApiBearerAuth, ApiOAuth2, ApiTags } from '@nestjs/swagger';
@ApiTags('App')
@Controller()
export class AppController {
  constructor(private readonly appService: AppService) {}

  @Get('/public')
  @Unprotected()
  getPublic(): string {
    return this.appService.getHello() + ' - Public';
  }

  @Get('/user')
  @ApiOAuth2([])
  @Unprotected()
  getUser(): string {
    return this.appService.getHello() + ' - User';
  }

  @Get('/admin')
  getAdmin(): string {
    return this.appService.getHello() + ' - Admin';
  }

  @Get('/all')
  getAll(): string {
    return this.appService.getHello() + ' - All';
  }
}
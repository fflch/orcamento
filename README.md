Transformar usuário em admin pelo tinker:

    php artisan tinker
    User:all()
    $eu = User::find(1);
    $eu->perfil = 'Administrador';
    $eu->save();
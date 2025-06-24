import csv

# Número de cuentas a generar
cantidad_usuarios = 130

# Nombre del archivo CSV que usarás en JMeter
nombre_archivo = 'usuarios.csv'

with open(nombre_archivo, mode='w', newline='') as archivo_csv:
    writer = csv.writer(archivo_csv)
    
    # Encabezado (puedes quitarlo si prefieres)
    writer.writerow(['username', 'password'])

    for i in range(1, cantidad_usuarios + 1):
        username = f"user{i}@mail.cl"
        password = f"clave{i}"
        writer.writerow([username, password])

print(f"CSV '{nombre_archivo}' generado con {cantidad_usuarios} cuentas.")


'''
INSERT INTO usuarios (email, rut, nombres, contraseña, rol) VALUES
('user1@mail.cl', '11111111-1', 'user1', 'clave1', 'Bibliotecóloga'),
('user2@mail.cl', '11111111-2', 'user2', 'clave2', 'Bibliotecóloga'),
('user3@mail.cl', '11111111-3', 'user3', 'clave3', 'Bibliotecóloga'),
('user4@mail.cl', '11111111-4', 'user4', 'clave4', 'Bibliotecóloga'),
('user5@mail.cl', '11111111-5', 'user5', 'clave5', 'Bibliotecóloga'),
('user6@mail.cl', '11111111-6', 'user6', 'clave6', 'Bibliotecóloga'),
('user7@mail.cl', '11111111-7', 'user7', 'clave7', 'Bibliotecóloga'),
('user8@mail.cl', '11111111-8', 'user8', 'clave8', 'Bibliotecóloga'),
('user9@mail.cl', '11111111-9', 'user9', 'clave9', 'Bibliotecóloga'),
('user10@mail.cl', '11111111-10', 'user10', 'clave10', 'Bibliotecóloga'),
('user11@mail.cl', '11111111-11', 'user11', 'clave11', 'Bibliotecóloga'),
('user12@mail.cl', '11111111-12', 'user12', 'clave12', 'Bibliotecóloga'),
('user13@mail.cl', '11111111-13', 'user13', 'clave13', 'Bibliotecóloga'),
('user14@mail.cl', '11111111-14', 'user14', 'clave14', 'Bibliotecóloga'),
('user15@mail.cl', '11111111-15', 'user15', 'clave15', 'Bibliotecóloga'),
('user16@mail.cl', '11111111-16', 'user16', 'clave16', 'Bibliotecóloga'),
('user17@mail.cl', '11111111-17', 'user17', 'clave17', 'Bibliotecóloga'),
('user18@mail.cl', '11111111-18', 'user18', 'clave18', 'Bibliotecóloga'),
('user19@mail.cl', '11111111-19', 'user19', 'clave19', 'Bibliotecóloga'),
('user20@mail.cl', '11111111-20', 'user20', 'clave20', 'Bibliotecóloga');



DELETE FROM usuarios
WHERE nombres IN (
    'user1', 'user2', 'user3', 'user4', 'user5',
    'user6', 'user7', 'user8', 'user9', 'user10',
    'user11', 'user12', 'user13', 'user14', 'user15',
    'user16', 'user17', 'user18', 'user19', 'user20'
);


'''

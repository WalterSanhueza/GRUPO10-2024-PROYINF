cantidad = 130
nombre_archivo = "login.csv"

with open(nombre_archivo, "w", encoding="utf-8") as archivo:
    for i in range(1, cantidad + 1):
        email = f"user{i}@mail.cl"
        rut = f"11111111-{i}"
        usuario = f"user{i}"
        clave = f"clave{i}"
        rol = "Bibliotecóloga"

        linea = f"('{email}', '{rut}', '{usuario}', '{clave}', '{rol}')"

        if i < cantidad:
            archivo.write(linea + ",\n")
        else:
            archivo.write(linea + ";\n")  # Cierra la consulta con punto y coma

print(f"Archivo '{nombre_archivo}' generado con {cantidad} usuarios.")

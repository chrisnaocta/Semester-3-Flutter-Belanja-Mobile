import 'package:flutter/material.dart';
import 'login.dart'; // Import login.dart

void main() {
  runApp(MyApp());
}

class MyApp extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'Toko Online',
      theme: ThemeData(
        primarySwatch: Colors.blue,
      ),
      home: LoginPage(), // Menetapkan LoginPage sebagai halaman utama
    );
  }
}

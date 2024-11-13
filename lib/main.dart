import 'package:flutter/material.dart';
import 'login.dart'; // Import login.dart

void main() {
  runApp(MyApp());
}

class MyApp extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'Login App',
      home: LoginPage(), // Replace with your login widget name
    );
  }
}

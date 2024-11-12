import 'package:flutter/material.dart';


class ForgotPasswordPage extends StatefulWidget {
  @override
  _ForgotPasswordPageState createState() => _ForgotPasswordPageState();
}


class _ForgotPasswordPageState extends State<ForgotPasswordPage> {
  final TextEditingController _emailController = TextEditingController();
  String _message = '';


  Future<void> _resetPassword() async {
    // Implementasikan logika untuk mengirim email reset password
  }


  @override
  Widget build(BuildContext context) {
    final screenWidth = MediaQuery.of(context).size.width;
    final screenHeight = MediaQuery.of(context).size.height;


    return Scaffold(
      appBar: AppBar(title: Text('Lupa Password')),
      body: Stack(
        children: [
          // Gambar latar belakang
          Positioned.fill(
            child: Image.asset(
              'assets/images/Gambar_login2.png',
              fit: BoxFit.cover, // Mengisi seluruh latar belakang
            ),
          ),


          // Konten di atas gambar
          Padding(
            padding: const EdgeInsets.all(16.0),
            child: Column(
              mainAxisAlignment: MainAxisAlignment.center,
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                // Logo di bagian atas
                Center(
                  child: CircleAvatar(
                    radius: 50,
                    backgroundImage: AssetImage(
                        'assets/images/logo.png'), // Sesuaikan dengan path logo
                  ),
                ),
                SizedBox(height: 24),


                // Pesan di bawah logo, margin sama dengan input email
                Center(
                  child: SizedBox(
                    width: screenWidth * 0.8,
                    child: Text(
                      'Lupa Password',
                      textAlign: TextAlign.center,
                      style: TextStyle(
                        fontWeight: FontWeight.bold,
                        fontSize: 40,
                        color: Colors.black, // Teks berwarna putih agar kontras
                      ),
                    ),
                  ),
                ),
                SizedBox(height: 50),


                // Pesan "Pesan:", margin sejajar dengan isian email
                Center(
                  child: SizedBox(
                    width: screenWidth * 0.8,
                    child: Text(
                      'Pesan:',
                      textAlign: TextAlign.left,
                      style: TextStyle(
                        fontWeight: FontWeight.bold,
                        fontSize: 16,
                        color: Colors.black, // Teks berwarna putih
                      ),
                    ),
                  ),
                ),
                SizedBox(height: 5),


                // Deskripsi pesan dengan margin kiri kanan sejajar isian email
                Center(
                  child: SizedBox(
                    width: screenWidth * 0.8,
                    child: Text(
                      'Masukkan email Anda dan tunggu kode etik akan dikirimkan.',
                      textAlign: TextAlign.left,
                      style: TextStyle(
                        fontWeight: FontWeight.normal,
                        fontSize: 14,
                        color: Colors.black, // Teks berwarna putih
                      ),
                    ),
                  ),
                ),
                SizedBox(height: 24),


                // TextField email dengan desain kapsul dan ikon email
                Center(
                  child: SizedBox(
                    width: screenWidth * 0.8, // Ukuran lebar menyesuaikan layar
                    child: TextField(
                      controller: _emailController,
                      decoration: InputDecoration(
                        labelText: 'Masukkan Email',
                        prefixIcon: Icon(Icons.email),
                        border: OutlineInputBorder(
                          borderRadius: BorderRadius.circular(30),
                        ),
                        contentPadding: EdgeInsets.symmetric(horizontal: 20),
                        filled: true,
                        fillColor: Colors.white
                            .withOpacity(0.8), // Transparansi untuk kontras
                      ),
                    ),
                  ),
                ),
                SizedBox(height: 24),


                // Tombol Reset Password
                Center(
                  child: SizedBox(
                    width: screenWidth * 0.6,
                    child: ElevatedButton(
                      onPressed: _resetPassword,
                      child: Text('Reset Password'),
                      style: ElevatedButton.styleFrom(
                        shape: RoundedRectangleBorder(
                          borderRadius:
                              BorderRadius.circular(30), // Bentuk kapsul
                        ),
                        padding: EdgeInsets.symmetric(
                            vertical: 16), // Ukuran tinggi tombol
                      ),
                    ),
                  ),
                ),
                SizedBox(height: 16),


                // Pesan error atau status
                Center(
                  child: Text(
                    _message,
                    style: TextStyle(color: Colors.red),
                  ),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }
}
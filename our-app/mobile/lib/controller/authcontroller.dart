import 'dart:convert';
import 'dart:io';

import 'package:mobile/constant/links.dart';
import 'package:http/http.dart' as http;
import 'package:mobile/controller/authManager.dart';

class AuthCont {
  static Future<http.Response> loginAuth(email, pass) async {
    var url = login;
    var res = await http
        .post(Uri.parse(url), body: {"email": email, "password": pass});
    return res;
  }

  // مالو داعي ما استخدمتو
  static Future<http.Response> service_first_type_Auth() async {
    var url = services_first_type;
    var res = await http.get(Uri.parse(url));
    return res;
  }

  static Future<http.Response> service_second_type_Auth(t_id) async {
    var url = services_second_type;
    var res = await http.post(Uri.parse(url), body: {"t_id": t_id});
    return res;
  }

  static Future<http.Response> addService(
      String name,
      String price,
      String subCategory,
      String description,
      String duration,
      String img_path,
      String img_name) async {
    var url = add_service;
    var res = await http.post(Uri.parse(url), body: {
      'service_name': name,
      'service_price': price,
      //'mainCategory': mainCategory,
      'service_sec_type': subCategory,
      'service_desc': description,
      'service_duration': duration,
      'service_img': img_path,
      'img_name': img_name,
      'token': AuthManager.getToken(),
    });
    return res;
  }

  static Future<http.Response> addJob(
    String j_name,
    String j_desc,
    String j_sal,
    String j_req,
  ) async {
    var url = add_job;
    var res = await http.post(Uri.parse(url), body: {
      'j_name': j_name,
      'j_desc': j_desc,
      'j_sal': j_sal,
      'j_req': j_req,
      'token': AuthManager.getToken(),
    });
    return res;
  }

  static Future<http.Response> add_cv(
    String career_obj,
    String phone,
    String address,
    String email,
  ) async {
    var url = add_main_cv;
    var res = await http.post(Uri.parse(url), body: {
      'career_obj': career_obj,
      'phone': phone,
      'address': address,
      'email': email,
      'token': AuthManager.getToken(),
    });
    return res;
  }

  static Future<http.Response> add_skills(
    String cv_id,
    List<dynamic> skills,
  ) async {
    var url = add_cv_skills;
    var res = await http.post(Uri.parse(url),
        body: jsonEncode({
          'cv_id': cv_id,
          'skills': skills,
        }));
    return res;
  }

  static Future<http.Response> add_training_courses(
    String cv_id,
    List<dynamic> courses,
  ) async {
    var url = add_cv_training_courses;
    var res = await http.post(Uri.parse(url),
        body: jsonEncode({
          'cv_id': cv_id,
          'training_courses': courses,
        }));
    return res;
  }

  static Future<http.Response> add_exp(
    String cv_id,
    List<dynamic> exp,
  ) async {
    var url = add_cv_exp;
    var res = await http.post(Uri.parse(url),
        body: jsonEncode({
          'cv_id': cv_id,
          'experiences': exp,
        }));
    return res;
  }

  static Future<http.Response> add_projects(
    String cv_id,
    List<dynamic> projects,
  ) async {
    var url = add_cv_projects;
    var res = await http.post(Uri.parse(url),
        body: jsonEncode({
          'cv_id': cv_id,
          'projects': projects,
        }));
    return res;
  }

  static Future<http.Response> add_education(
    String cv_id,
    List<dynamic> edu,
  ) async {
    var url = add_cv_education;
    var res = await http.post(Uri.parse(url),
        body: jsonEncode({
          'cv_id': cv_id,
          'education': edu,
        }));
    return res;
  }
}

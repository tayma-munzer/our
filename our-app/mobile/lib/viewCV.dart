import 'package:flutter/material.dart';
import 'package:mobile/constant/links.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';
import 'package:mobile/appbar.dart';
import 'package:mobile/bottombar.dart';
import 'package:mobile/controller/authManager.dart';
import 'package:mobile/drawer.dart';
import 'package:mobile/editcv.dart';
import 'package:mobile/editexp.dart';
import 'package:mobile/editproject.dart';
import 'package:mobile/editskill.dart';
import 'package:mobile/edittrainingcourse.dart';

class viewcv extends StatefulWidget {
  const viewcv({Key? key}) : super(key: key);

  @override
  State createState() => _viewcvState();
}

class _viewcvState extends State {
  Map mainInfo = {};
  List skills = [];
  List training_courses = [];
  List experience = [];
  List projects = [];
  List education = [];
  List languages = [];

  void fetch() async {
    String? token = await AuthManager.getToken();
    print('object');
    var url = get_all_cv;
    var res = await http.post(Uri.parse(url), body: {'token': token});
    Map<String, dynamic> data = json.decode(res.body);
    setState(() {
      mainInfo = data['cv'];
      skills = data['skills'];
      training_courses = data['training_courses'];
      experience = data['experience'];
      projects = data['projects'];
      education = data['education'];
      languages = data['languages'];
      print(mainInfo);
      print(skills);
      print(training_courses);
      print(experience);
      print(projects);
      print(education);
      print(languages);
    });
  }

  @override
  void initState() {
    super.initState();
    fetch();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: PreferredSize(
        preferredSize: Size.fromHeight(33.0),
        child: CustomAppBar(),
      ),
      drawer: CustomDrawer(),
      body: SingleChildScrollView(
        child: Padding(
          padding: EdgeInsets.only(right: 10.0),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.end,
            children: [
              Row(
                mainAxisAlignment: MainAxisAlignment.end,
                children: [
                  Expanded(
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.end,
                      children: [
                        SizedBox(
                          height: 30,
                        ),
                        Row(
                          mainAxisAlignment: MainAxisAlignment.end,
                          children: [
                            IconButton(
                              padding: EdgeInsets.only(right: 8.0),
                              icon: Icon(Icons.edit),
                              onPressed: () {
                                Navigator.push(
                                  context,
                                  MaterialPageRoute(
                                      builder: (context) => EditCv()),
                                );
                              },
                            ),
                            Text(
                              ' المعلومات الاساسية',
                              style: TextStyle(
                                fontWeight: FontWeight.bold,
                                fontSize: 20,
                              ),
                              textAlign: TextAlign.right,
                            ),
                          ],
                        ),
                        Text(
                          ' ${mainInfo['email']}  : البريد الالكتروني',
                          textAlign: TextAlign.right,
                          style: TextStyle(
                            fontWeight: FontWeight.bold,
                            fontSize: 18,
                          ),
                        ),
                        Text(
                          ' ${mainInfo['phone']}: رقم الهاتف',
                          textAlign: TextAlign.right,
                          style: TextStyle(
                            fontWeight: FontWeight.bold,
                            fontSize: 18,
                          ),
                        ),
                        Text(
                          ' ${mainInfo['address']} : العنوان ',
                          textAlign: TextAlign.right,
                          style: TextStyle(
                            fontWeight: FontWeight.bold,
                            fontSize: 18,
                          ),
                        ),
                        Text(
                          ' ${mainInfo['career_obj']} : الهدف الوظيفي',
                          textAlign: TextAlign.right,
                          style: TextStyle(
                            fontWeight: FontWeight.bold,
                            fontSize: 18,
                          ),
                        ),
                      ],
                    ),
                  ),
                ],
              ),
              SizedBox(
                height: 20,
              ),
              Row(
                mainAxisAlignment: MainAxisAlignment.end,
                children: [
                  IconButton(
                    padding: EdgeInsets.only(right: 8.0),
                    icon: Icon(Icons.add),
                    onPressed: () {
                      Navigator.push(
                        context,
                        MaterialPageRoute(builder: (context) => EditCv()),
                      );
                    },
                  ),
                  Text(
                    ' المهارات',
                    style: TextStyle(
                      fontWeight: FontWeight.bold,
                      fontSize: 20,
                    ),
                    textAlign: TextAlign.right,
                  ),
                ],
              ),
              Column(
                children: [
                  SizedBox(
                    height: 10,
                  ),
                  if (skills.isEmpty)
                    Text('No skills to be displayed')
                  else
                    for (int i = 0; i < skills.length; i++)
                      Container(
                        color: i % 2 == 0
                            ? const Color.fromARGB(255, 168, 216, 255)
                            : Colors.white,
                        padding: EdgeInsets.all(10),
                        width: double.infinity,
                        child: Row(
                          mainAxisAlignment: MainAxisAlignment.end,
                          children: [
                            IconButton(
                              icon: Icon(Icons.edit),
                              onPressed: () {
                                Navigator.push(
                                  context,
                                  MaterialPageRoute(
                                      builder: (context) =>
                                          editskill(skills[i]['s_id'])),
                                );
                              },
                            ),
                            Column(
                              crossAxisAlignment: CrossAxisAlignment.end,
                              children: [
                                Text(
                                  ' اسم المهارة : ${skills[i]['s_name']} \n عدد سنين الخبرة : ${skills[i]['years_of_exp']} \n مستوى المهارة :${skills[i]['s_level']}',
                                  style: TextStyle(
                                    color: Colors.black,
                                    fontWeight: FontWeight.bold,
                                    fontSize: 16,
                                  ),
                                  textAlign: TextAlign.right,
                                ),
                              ],
                            ),
                          ],
                        ),
                      ),
                ],
              ),
              Text(
                'الدورات التدريبية ',
                style: TextStyle(
                  fontWeight: FontWeight.bold,
                  fontSize: 20,
                ),
              ),
              Column(
                children: [
                  SizedBox(
                    height: 10,
                  ),
                  if (training_courses.isEmpty)
                    Text('No courses to be displayed')
                  else
                    for (int i = 0; i < training_courses.length; i++)
                      Container(
                        color: i % 2 == 0
                            ? const Color.fromARGB(255, 168, 216, 255)
                            : Colors.white,
                        padding: EdgeInsets.all(10),
                        width: double.infinity,
                        child: Row(
                          mainAxisAlignment: MainAxisAlignment.end,
                          children: [
                            IconButton(
                              padding: EdgeInsets.only(right: 100.0),
                              icon: Icon(Icons.edit),
                              onPressed: () {
                                // Navigator.push(
                                //   context,
                                //   MaterialPageRoute(
                                //       builder: (context) => edittrainingcourse(
                                //           training_courses[i]['t_id'])),
                                // );
                              },
                            ),
                            Column(
                              crossAxisAlignment: CrossAxisAlignment.end,
                              children: [
                                Text(
                                  ' اسم الدورة : ${training_courses[i]['course_name']} \n اسم مركز التدريب: ${training_courses[i]['training_center']} \n  تاريخ انهاء الدورة :${training_courses[i]['completion_date']}',
                                  style: TextStyle(
                                    color: Colors.black,
                                    fontWeight: FontWeight.bold,
                                    fontSize: 16,
                                  ),
                                  textAlign: TextAlign.right,
                                ),
                              ],
                            ),
                          ],
                        ),
                      ),
                ],
              ),
              Text(
                ' الخبرة ',
                style: TextStyle(
                  fontWeight: FontWeight.bold,
                  fontSize: 20,
                ),
              ),
              Column(
                children: [
                  SizedBox(
                    height: 10,
                  ),
                  if (experience.isEmpty)
                    Text('No exp to be displayed')
                  else
                    for (int i = 0; i < experience.length; i++)
                      Container(
                        color: i % 2 == 0
                            ? const Color.fromARGB(255, 168, 216, 255)
                            : Colors.white,
                        padding: EdgeInsets.all(10),
                        width: double.infinity,
                        child: Row(
                          mainAxisAlignment: MainAxisAlignment.end,
                          children: [
                            IconButton(
                              padding: EdgeInsets.only(right: 10.0),
                              icon: Icon(Icons.edit),
                              onPressed: () {
                                Navigator.push(
                                  context,
                                  MaterialPageRoute(
                                      builder: (context) =>
                                          editexp(experience[i]['exp_id'])),
                                );
                              },
                            ),
                            Column(
                              crossAxisAlignment: CrossAxisAlignment.end,
                              children: [
                                Text(
                                  ' اسم الشركة او مكان العمل : ${experience[i]['company']} \n   المسمى الوظيفي : ${experience[i]['position']} \n  تاريخ البدء في العمل :${experience[i]['start_date']} \n تاريخ انهاءالعمل :${experience[i]['end_date']} \n  المسؤوليات في العمل: ${experience[i]['responsibilities']} ',
                                  style: TextStyle(
                                    color: Colors.black,
                                    fontWeight: FontWeight.bold,
                                    fontSize: 16,
                                  ),
                                  textAlign: TextAlign.right,
                                ),
                              ],
                            ),
                          ],
                        ),
                      ),
                ],
              ),
              Text(
                ' المشاريع ',
                style: TextStyle(
                  fontWeight: FontWeight.bold,
                  fontSize: 20,
                ),
              ),
              Column(
                children: [
                  SizedBox(
                    height: 10,
                  ),
                  if (projects.isEmpty)
                    Text('No projects to be displayed')
                  else
                    for (int i = 0; i < projects.length; i++)
                      Container(
                        color: i % 2 == 0
                            ? const Color.fromARGB(255, 168, 216, 255)
                            : Colors.white,
                        padding: EdgeInsets.all(10),
                        width: double.infinity,
                        child: Row(
                          mainAxisAlignment: MainAxisAlignment.end,
                          children: [
                            IconButton(
                              padding: EdgeInsets.only(right: 10.0),
                              icon: Icon(Icons.edit),
                              onPressed: () {
                                Navigator.push(
                                  context,
                                  MaterialPageRoute(
                                      builder: (context) =>
                                          projectedit(projects[i]['p_id'])),
                                );
                              },
                            ),
                            Column(
                              crossAxisAlignment: CrossAxisAlignment.end,
                              children: [
                                Text(
                                  '   عنوان المشروع : ${projects[i]['p_name']} \n  وصف المشروع : ${projects[i]['p_desc']} \n  تاريخ البدء في المشروع :${projects[i]['start_date']} \n تاريخ انهاء العمل :${projects[i]['end_date']} \n  المسؤوليات في المشروع: ${projects[i]['responsibilities']} ',
                                  style: TextStyle(
                                    color: Colors.black,
                                    fontWeight: FontWeight.bold,
                                    fontSize: 15,
                                  ),
                                  textAlign: TextAlign.right,
                                ),
                              ],
                            ),
                          ],
                        ),
                      ),
                ],
              ),
              Text(
                ' اللغات ',
                style: TextStyle(
                  fontWeight: FontWeight.bold,
                  fontSize: 20,
                ),
              ),
              Column(
                children: [
                  SizedBox(
                    height: 10,
                  ),
                  if (languages.isEmpty)
                    Text('No languages to be displayed')
                  else
                    for (int i = 0; i < languages.length; i++)
                      Container(
                        color: i % 2 == 0
                            ? const Color.fromARGB(255, 168, 216, 255)
                            : Colors.white,
                        padding: EdgeInsets.all(10),
                        width: double.infinity,
                        child: Row(
                          mainAxisAlignment: MainAxisAlignment.end,
                          children: [
                            IconButton(
                              padding: EdgeInsets.only(right: 250.0),
                              icon: Icon(Icons.delete),
                              onPressed: () async {
                                var url = delete_cv_language;
                                var res = await http
                                    .post(Uri.parse(url), body: {
                                  'cvl_id': languages[i]['cvl_id'].toString()
                                });
                                if (res.statusCode == 200) {
                                  print('deleted seccessfully');
                                  var url = get_cv_lang;
                                  var res = await http.post(Uri.parse(url),
                                      body: {
                                        'cv_id': mainInfo['cv_id'].toString()
                                      });
                                  Map data = json.decode(res.body);
                                  setState(() {
                                    languages = data['languages'];
                                  });
                                } else {
                                  print('something went wrong');
                                }
                              },
                            ),
                            Column(
                              crossAxisAlignment: CrossAxisAlignment.end,
                              children: [
                                Text(
                                  '  ${languages[i]['language']} ',
                                  style: TextStyle(
                                    color: Colors.black,
                                    fontWeight: FontWeight.bold,
                                    fontSize: 16,
                                  ),
                                  textAlign: TextAlign.right,
                                ),
                              ],
                            ),
                          ],
                        ),
                      ),
                ],
              ),
              Text(
                ' التعليم ',
                style: TextStyle(
                  fontWeight: FontWeight.bold,
                  fontSize: 20,
                ),
              ),
              Column(
                children: [
                  SizedBox(
                    height: 10,
                  ),
                  if (education.isEmpty)
                    Text('No education to be displayed')
                  else
                    for (int i = 0; i < education.length; i++)
                      Container(
                        color: i % 2 == 0
                            ? const Color.fromARGB(255, 168, 216, 255)
                            : Colors.white,
                        padding: EdgeInsets.all(10),
                        width: double.infinity,
                        child: Row(
                          mainAxisAlignment: MainAxisAlignment.end,
                          children: [
                            IconButton(
                              padding: EdgeInsets.only(right: 60.0),
                              icon: Icon(Icons.edit),
                              onPressed: () {
                                // Navigator.push(
                                //   context,
                                //   MaterialPageRoute(
                                //       builder: (context) => EditSkill()),
                                // );
                              },
                            ),
                            Column(
                              crossAxisAlignment: CrossAxisAlignment.end,
                              children: [
                                Text(
                                  'اسم الجامعة : ${education[i]['uni']} \n    اختصاص الدراسة : ${education[i]['field_of_study']} \n  درجة الشهادة :${education[i]['degree']} \n  سنة التخرج :${education[i]['grad_year']} \n   المعدل التراكمي : ${education[i]['gba']} ',
                                  style: TextStyle(
                                    color: Colors.black,
                                    fontWeight: FontWeight.bold,
                                    fontSize: 16,
                                  ),
                                  textAlign: TextAlign.right,
                                ),
                              ],
                            ),
                          ],
                        ),
                      ),
                ],
              ),
            ],
          ),
        ),
      ),
      bottomNavigationBar: BottomBar(),
    );
  }
}

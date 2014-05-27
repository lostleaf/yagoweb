class Model
	words = File.read("query.txt").split(/\n\n+/).map{|x| x.split("\n")}
	@@descriptions, @@queries = words.inject([[],[]]) {|l, e| l[0]<<e[0];l[1]<<e[1];l}
	@@client = Mysql2::Client.new(
		:host => "211.80.57.220",   
		:username => "yago",   
		password: "2UejLBzC8hHcrZKd",  
		database: "yago"  
	)

	def self.descriptions
		@@descriptions
	end

	def self.query(type, arg)
		type = type.to_i
		if type > 0
			sql = @@queries[type].gsub('?', @@client.escape(arg))
		else
			args = arg.strip.split(/\s/)
			temp1 = "select id from yname where yname = \"?\""
			temp2 = "select yfact_id from yname_yfact where yname_id = (?)"
			temp3 = "select distinct entity1 from yfact where id in (?)"
			temp4 = "select yfact_id from yname_yfact where yname_id = (?) and yfact_id in (@)"

			sql = temp2.gsub("?", temp1.gsub("?", @@client.escape(args[0])))

			args[1..-1].each do |arg|
				sql = temp4.gsub("?", temp1.gsub("?", @@client.escape(arg))).gsub("@", sql)
			end
			sql = temp3.gsub("?", sql)
		end

		res = @@client.query(sql, :as => :array)
		[res.fields, res.to_a]
	end

end